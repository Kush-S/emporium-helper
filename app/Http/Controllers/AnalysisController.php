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


    $selected_zybooks_file = $request->selected_zybooks_file;
    $selected_canvas_file = $request->selected_canvas_file;
    error_log($request->selected_zybooks_file);
    error_log($request->selected_canvas_file);

    $randNums = array();
    array_push($randNums, rand(1,15), rand(1,15), rand(1,15), rand(1,15), rand(1,15), rand(1,15));

    return view('analysis')
      ->with('randNums', $randNums)
      ->with('classroom', $this->classroom)
      ->with('zybooks_files', $zybooks_files)
      ->with('canvas_files', $canvas_files)
      ->with('selected_zybooks_file', $selected_zybooks_file)
      ->with('selected_canvas_file', $selected_canvas_file);
  }

  public function student_list()
  {
    return view('analysis_student_list');
  }

  public function student_info()
  {
    return view('analysis_student_info');
  }

  public function recalculateRisk()
  {
    $this->setParsedToFalse();
    // foreach(ZybooksFile::all() as $file){
    //   if ($file->parsed["student_info"] == false){
    //     $file_name = escapeshellarg($file->name);
    //
    //     // student info - build and run python command
    //     $shell_command = "python python_scripts/parseStudents.py ../storage/app/zybooks_files/" . $file_name;
    //     error_log($shell_command);
    //     $output_json = shell_exec($shell_command);
    //
    //     // decode output from python to JSON
    //     $output_json = json_decode($output_json, true);
    //
    //     // store each student, if already not stored
    //     foreach ($output_json as $info)
    //     {
    //       error_log("student");
    //       $student = Student::firstOrCreate([
    //         'first_name' => $info['First name'],
    //         'last_name' => $info['Last name'],
    //         'email' => $info['Primary email']
    //       ]);
    //     }
    //
    //     $temp = $file->parsed;
    //     $temp["student_info"] = true;
    //     $file->parsed = $temp;
    //     $file->save();
    //   }
    // }

    return redirect()->route('statistics_index');
  }

  private function setParsedToFalse()
  {
    foreach(ZybooksFile::all() as $file){
      $temp = $file->parsed;
      $temp["participation_total"] = $temp["challenge_total"] = $temp["lab_total"] = $temp["total"] = false;

      $file->parsed = $temp;
      $file->save();
    }
  }
}
