<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ZybooksFile;
use App\Models\Student;
use App\Models\Risk;

class StatisticsController extends Controller
{
  public function index()
  {
    // $risk = Risk::select('name')->get();

    return view('statistics');
  }

  public function recalculateRisk()
  {
    foreach(ZybooksFile::all() as $file){
      if ($file->parsed["student_info"] == false){
        $file_name = escapeshellarg($file->name);

        // student info - build and run python command
        $shell_command = "python python_scripts/parseStudents.py ../storage/app/zybooks_files/" . $file_name;
        error_log($shell_command);
        $output_json = shell_exec($shell_command);

        // decode output from python to JSON
        $output_json = json_decode($output_json, true);

        // store each student, if already not stored
        foreach ($output_json as $info)
        {
          error_log("student");
          $student = Student::firstOrCreate([
            'first_name' => $info['First name'],
            'last_name' => $info['Last name'],
            'email' => $info['Primary email']
          ]);
        }

        $temp = $file->parsed;
        $temp["student_info"] = true;
        $file->parsed = $temp;
        $file->save();
      }
    }

    return redirect()->route('statistics_index');
  }
}
