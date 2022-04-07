<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ZybooksFile;
use App\Models\Student;
use App\Models\Classroom;
use App\Models\Risk;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Mail;
use App\Mail\StudentNotification;

class AnalysisController extends Controller
{
  public function __construct(Request $request)
  {
    $this->classroom = Classroom::find($request->id);
  }

  public function index(Request $request)
  {
    // If a previous analysis was done
    if($this->classroom->files_selected["zybooks"] != "None" || $this->classroom->files_selected["canvas"] != "None")
    {
      return redirect()->route("analysis_show", $request->id);
    }

    // zyBooks files for this classroom
    $zybooks_files = ZybooksFile
    ::where('classroom_id', $this->classroom->id)
    ->where('type', 'zybooks')->get()->sortBy('name');

    // Canvas files for this classroom
    $canvas_files = ZybooksFile
    ::where('classroom_id', $this->classroom->id)
    ->where('type', 'canvas')->get()->sortBy('name');

    return view('analysis')
      ->with('classroom', $this->classroom)
      ->with('zybooks_files', $zybooks_files)
      ->with('canvas_files', $canvas_files);
  }

  public function file_selected(Request $request)
  {
    $selected_files["zybooks"] = $request->selected_zybooks_file;
    $selected_files["canvas"] = $request->selected_canvas_file;
    $this->classroom->files_selected = $selected_files;
    $this->classroom->save();

    return redirect()->route("analysis_index", $request->id);
  }

  public function show_analysis()
  {
    // Get names of file(s) selected
    $selected_zybooks_file = $this->classroom->files_selected["zybooks"];
    $selected_canvas_file = $this->classroom->files_selected["canvas"];

    // zyBooks files for this classroom
    $zybooks_files = ZybooksFile
    ::where('classroom_id', $this->classroom->id)
    ->where('type', 'zybooks')->get()->sortBy('name');

    // Canvas files for this classroom
    $canvas_files = ZybooksFile
    ::where('classroom_id', $this->classroom->id)
    ->where('type', 'canvas')->get()->sortBy('name');

    // *** If both files selected ***
    if($selected_zybooks_file != "None" && $selected_canvas_file != "None"){
      $selected_files["zybooks"] = $selected_zybooks_file;
      $selected_files["canvas"] = $selected_canvas_file;
      $this->classroom->files_selected = $selected_files;
      $this->classroom->save();

      $mixClassStats = $this->getMixData('parseMixStats.py', $selected_canvas_file, $selected_zybooks_file);
      $mixClassStats = json_decode($mixClassStats, true);

      // set risk for this class
      $this->classroom->at_risk = $mixClassStats['At risk'];
      $this->classroom->save();

      return view('analysis.mix')
            ->with('classroom', $this->classroom)
            ->with('zybooks_files', $zybooks_files)
            ->with('canvas_files', $canvas_files)
            ->with('selected_zybooks_file', $selected_zybooks_file)
            ->with('selected_canvas_file', $selected_canvas_file)
            ->with('mixClassStats', $mixClassStats);
    }

    // *** If only canvas file selected ***
    elseif($selected_canvas_file != "None"){

      // Set the last_analysis files value in database to only zybooks
      $selected_files["zybooks"] = "None";
      $selected_files["canvas"] = $selected_canvas_file;
      $this->classroom->files_selected = $selected_files;
      $this->classroom->save();

      $canvasStudentData = $this->getCanvasData('parseCanvas.py', $selected_canvas_file);
      $canvasStudentData = json_decode($canvasStudentData, true);

      $canvasClassStats = $this->getCanvasData('parseCanvasStats.py', $selected_canvas_file);
      $canvasClassStats = json_decode($canvasClassStats, true);

      // if the file is not a canvas file
      if($canvasStudentData == false)
        {
          return redirect()->route('analysis_index', $this->classroom->id)
                            ->with("error", "Unable to parse data, was that really a canvas file?");
        }

        // set risk for this class
        $this->classroom->at_risk = $canvasClassStats['At risk'];
        $this->classroom->save();

        return view('analysis.canvas')
              ->with('canvasStudentData', $canvasStudentData)
              ->with('canvasClassStats', $canvasClassStats)
              ->with('classroom', $this->classroom)
              ->with('zybooks_files', $zybooks_files)
              ->with('canvas_files', $canvas_files)
              ->with('selected_zybooks_file', $selected_zybooks_file)
              ->with('selected_canvas_file', $selected_canvas_file);
      }

    // *** If only zyBooks file selected ***
    elseif($selected_zybooks_file != "None"){

      // Set the last_analysis files value in database to only zybooks
      $selected_files["zybooks"] = $selected_zybooks_file;
      $selected_files["canvas"] = "None";
      $this->classroom->files_selected = $selected_files;
      $this->classroom->save();

      $zybooksStudentData = $this->getZybooksData('parseZybooks.py', $selected_zybooks_file);
      $zybooksStudentData = json_decode($zybooksStudentData, true);

      $zybooksClassStats = $this->getZybooksData('parseZybooksStats.py', $selected_zybooks_file);
      $zybooksClassStats = json_decode($zybooksClassStats, true);

      if ($zybooksClassStats == false || $zybooksStudentData == false)
        {
          return redirect()->route('analysis_index', $this->classroom->id)
                            ->with("error", "Unable to parse data, was that really a zyBooks file?");
        }

      // set risk for this class
      $this->classroom->at_risk = $zybooksClassStats['At risk'];
      $this->classroom->save();


      return view('analysis.zybooks')
            ->with('zybooksStudentData', $zybooksStudentData)
            ->with('zybooksClassStats', $zybooksClassStats)
            ->with('classroom', $this->classroom)
            ->with('zybooks_files', $zybooks_files)
            ->with('canvas_files', $canvas_files)
            ->with('selected_zybooks_file', $selected_zybooks_file)
            ->with('selected_canvas_file', $selected_canvas_file);
      }
  }

  public function student_list_zybooks(Request $request)
  {
    $zybooksClassStats = json_decode($request->zybooksClassStats, true);
    $zybooksStudentData = json_decode($request->zybooksStudentData, true);

    return view('analysis.zybooks_student_list')
          ->with('zybooksClassStats', $zybooksClassStats)
          ->with('classroom', $this->classroom)
          ->with('selected_zybooks_file', $request->selected_zybooks_file)
          ->with('zybooksStudentData', $zybooksStudentData);
  }

  public function student_info_zybooks(Request $request)
  {
    $zybooksClassStats = json_decode($request->zybooksClassStats, true);
    $studentData = array(
      'first_name' => $request->first_name,
      'last_name' => $request->last_name,
      'risk' => $request->risk,
      'primary_email' => $request->primary_email,
      'school_email' => $request->school_email,
      'participation_total' => $request->participation_total,
      'challenge_total' => $request->challenge_total,
      'lab_total' => $request->lab_total,
    );

    return view('analysis.zybooks_student_info')
          ->with('zybooksClassStats', $zybooksClassStats)
          ->with('selected_zybooks_file', $request->selected_zybooks_file)
          ->with('classroom', $this->classroom)
          ->with('studentData', $studentData);
  }

  public function getZybooksData($script, $file)
  {
    // For ubuntu server
    $process = new Process(['python3', 'python_scripts/'.$script , '../storage/app/'.$this->classroom->id.'/zybooks/'.$file,
                          $this->classroom->risk_variables["zybooks"]["participation_m"],
                          $this->classroom->risk_variables["zybooks"]["participation_b"],
                          $this->classroom->risk_variables["zybooks"]["participation_weight"],
                          $this->classroom->risk_variables["zybooks"]["challenge_m"],
                          $this->classroom->risk_variables["zybooks"]["challenge_b"],
                          $this->classroom->risk_variables["zybooks"]["challenge_weight"],
                          $this->classroom->risk_variables["zybooks"]["lab_m"],
                          $this->classroom->risk_variables["zybooks"]["lab_b"],
                          $this->classroom->risk_variables["zybooks"]["lab_weight"],
                          ]);
    $process->run();

    // Make sure non zyabooks file's analysis doesn't happen
    if($process->isSuccessful() == "")
    {
      $selected_files["zybooks"] = "None";
      $selected_files["canvas"] = "None";
      $this->classroom->files_selected = $selected_files;
      $this->classroom->save();

      return false;
    }
    return $process->getOutput();

    // // For windows
    $file = escapeshellarg($file);
    $shell_command = 'python python_scripts/' . $script .' ../storage/app/' . $this->classroom->id . '/zybooks/' . $file . ' ' .
                    $this->classroom->risk_variables["zybooks"]["participation_m"] . ' ' .
                    $this->classroom->risk_variables["zybooks"]["participation_b"] . ' ' .
                    $this->classroom->risk_variables["zybooks"]["participation_weight"] . ' ' .
                    $this->classroom->risk_variables["zybooks"]["challenge_m"] . ' ' .
                    $this->classroom->risk_variables["zybooks"]["challenge_b"] . ' ' .
                    $this->classroom->risk_variables["zybooks"]["challenge_weight"] . ' ' .
                    $this->classroom->risk_variables["zybooks"]["lab_m"] . ' ' .
                    $this->classroom->risk_variables["zybooks"]["lab_b"] . ' ' .
                    $this->classroom->risk_variables["zybooks"]["lab_weight"];
    $output_json = shell_exec($shell_command);

    return $output_json;
  }

  public function getCanvasData($script, $file)
  {
    // For ubuntu server
    $process = new Process(['python3', 'python_scripts/'.$script , '../storage/app/'.$this->classroom->id.'/canvas/'.$file,
                          $this->classroom->risk_variables["canvas"]["risk_weight"],
                          ]);
    $process->run();

    // Make sure non canvas file's analysis doesn't happen
    if($process->isSuccessful() == "")
    {
      $selected_files["zybooks"] = "None";
      $selected_files["canvas"] = "None";
      $this->classroom->files_selected = $selected_files;
      $this->classroom->save();

      return false;
    }
    return $process->getOutput();

    // For windows
    $file = escapeshellarg($file);
    $shell_command = 'python python_scripts/' . $script .' ../storage/app/' . $this->classroom->id . '/canvas/' . $file . ' ' .
                    $this->classroom->risk_variables["canvas"]["risk_weight"];
    $output_json = shell_exec($shell_command);

    return $output_json;
  }

  public function student_list_canvas(Request $request)
  {
    $canvasClassStats = json_decode($request->canvasClassStats, true);
    $canvasStudentData = json_decode($request->canvasStudentData, true);

    return view('analysis.canvas_student_list')
          ->with('canvasClassStats', $canvasClassStats)
          ->with('classroom', $this->classroom)
          ->with('selected_canvas_file', $request->selected_canvas_file)
          ->with('canvasStudentData', $canvasStudentData);
  }

  public function student_info_canvas(Request $request)
  {
    $canvasClassStats = json_decode($request->canvasClassStats, true);
    $studentData = array(
      'student_name' => $request->student_name,
      'risk' => $request->risk,
      'student_id' => $request->student_id,
      'risk' => $request->risk,
      'final_points' => $request->final_points,
      'challenge_total' => $request->challenge_total,
      'final_score' => $request->final_score,
    );

    return view('analysis.canvas_student_info')
          ->with('canvasClassStats', $canvasClassStats)
          ->with('selected_canvas_file', $request->selected_canvas_file)
          ->with('classroom', $this->classroom)
          ->with('studentData', $studentData);
  }

  public function getMixData($script, $file1, $file2)
  {
    // For ubuntu server
    $process = new Process(['python3', 'python_scripts/'.$script,
                          '../storage/app/'.$this->classroom->id.'/canvas/'.$file1,
                          '../storage/app/'.$this->classroom->id.'/zybooks/'.$file2,
                          $this->classroom->risk_variables["mix"]["risk_weight"]
                          ]);
    $process->run();

    // Make sure wrong file's analysis doesn't happen
    if($process->isSuccessful() == "")
    {
      $selected_files["zybooks"] = "None";
      $selected_files["canvas"] = "None";
      $this->classroom->files_selected = $selected_files;
      $this->classroom->save();

      return false;
    }
    return $process->getOutput();

    // For windows
    $file1 = escapeshellarg($file1);
    $file2 = escapeshellarg($file2);
    $shell_command = 'python python_scripts/' . $script .
                    ' ../storage/app/' . $this->classroom->id .'/canvas/' . $file1 . ' ' .
                    ' ../storage/app/' . $this->classroom->id .'/zybooks/' . $file2 . ' ' .
                    $this->classroom->risk_variables["canvas"]["risk_weight"];
    $output_json = shell_exec($shell_command);

    return $output_json;
  }

  public function sendEmailToStudent(Request $request)
  {
    Mail::to('ksaxena@bgsu.edu')->send(new StudentNotification);
  }
}
