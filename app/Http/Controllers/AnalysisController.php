<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ZybooksFile;
use App\Models\Student;
use App\Models\Classroom;
use App\Models\Risk;

class AnalysisController extends Controller
{
  public function __construct(Request $request)
  {
    $this->classroom = Classroom::find($request->id);
  }

  public function index(Request $request)
  {
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
    // Get names of file(s) selected
    $selected_zybooks_file = $request->selected_zybooks_file;
    $selected_canvas_file = $request->selected_canvas_file;

    // If no files selected
    if($selected_zybooks_file == "None" && $selected_zybooks_file == "None")
    {
      return redirect()->route('analysis_index', $request->id);
    }

    // zyBooks files for this classroom
    $zybooks_files = ZybooksFile
    ::where('classroom_id', $this->classroom->id)
    ->where('type', 'zybooks')->get()->sortBy('name');

    // Canvas files for this classroom
    $canvas_files = ZybooksFile
    ::where('classroom_id', $this->classroom->id)
    ->where('type', 'canvas')->get()->sortBy('name');

    // If both files selected

    // If only canvas file selected

    // If only zyBooks file selected
    if($selected_zybooks_file != "None"){
      $zybooksStudentData = $this->getZybooksData('parseZybooks.py', $selected_zybooks_file);
      $zybooksStudentData = json_decode($zybooksStudentData, true);

      $zybooksClassStats = $this->getZybooksData('parseZybooksStats.py', $selected_zybooks_file);
      $zybooksClassStats = json_decode($zybooksClassStats, true);

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
    $zybooksStudentData = json_decode($request->zybooksStudentData, true);

    return view('analysis.zybooks_student_list')
          ->with('classroom', $this->classroom)
          ->with('selected_zybooks_file', $request->selected_zybooks_file)
          ->with('zybooksStudentData', $zybooksStudentData);
  }

  public function student_info_zybooks(Request $request)
  {
    $studentData = array(
      'first_name' => $request->first_name,
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
          ->with('selected_zybooks_file', $request->selected_zybooks_file)
          ->with('classroom', $this->classroom)
          ->with('studentData', $studentData);
  }

  public function getZybooksData($script, $file)
  {
    $shell_command = 'python python_scripts/' . $script .' ../storage/app/' . $this->classroom->id . '/zybooks/' . $file;
    error_log($shell_command);
    $output_json = shell_exec($shell_command);

    return $output_json;
  }
}
