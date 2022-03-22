<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ZybooksFile;
use App\Models\Student;
use App\Models\Classroom;
use Config;
use Illuminate\Support\Facades\Storage;
use App\Jobs\ProcessStudentGeneralInfo;

class ZybooksFileController extends Controller
{
  public function __construct(Request $request)
  {
    $this->classroom = Classroom::find($request->id);
  }

  public function index()
  {
    $files = ZybooksFile::select('name')->get();

    return view('zybooks_files')->with('files', $files)->with('classroom', $this->classroom);
  }

  public function uploadFile(Request $request)
  {
    // Verify file doesn't already exists for this classroom
    // However, both canvas and zybooks can have the same file (ex. week1.csv can exist in canvas and zybooks in same classroom)
    if(ZybooksFile::where('name',$request->input_file->getClientOriginalName())
      ->where('type', $request->type)
      ->where('classroom_id', $request->id)
      ->exists())
      {
        error_log('found already');
        return redirect()->route('files_index', $request->id)->with('error', '\'' . $request->input_file->getClientOriginalName() . '\'' . ' file already exists in this classroom!');
      }

    // Save file name in database
    $file = new ZybooksFile;
    $file->name = $request->input_file->getClientOriginalName();
    $file->type = $request->type;
    $file->classroom_id = $request->id;
    $file->save();

    // Save file to project directory
    $path = $request
            ->file('input_file')
            ->storeAs($file->classroom_id . '/' . $file->type, $file->name);

    // call parseFile() on uploaded file
    // $this->parseStudentInfo($file);

    return redirect()->route('files_index', $request->id)->with('status', 'File ' . '\'' . $file->name . '\'' . ' uploaded successfully!');
  }

  public function downloadFile($file)
  {
    return Storage::download('zybooks_files/' . $file);
  }

  public function deleteFile($file)
  {
    // delete from storage
    Storage::delete('zybooks_files/' . $file);

    // delete from database
    $database_file = ZybooksFile::where('name', $file)->first();
    $database_file->delete();

    return redirect()->route('files_index');
  }

  private function parseStudentInfo($file)
  {
    // clean file name in case of spaces
    $file_name = escapeshellarg($file->name);

    // build and run python command to get student info (first name, last name, email)
    $shell_command = "python python_scripts/parseStudents.py ../storage/app/zybooks_files/" . $file_name;
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

    // update parsed['student_info'] on $file to true
    $temp = $file->parsed;
    $temp["student_info"] = true;
    $file->parsed = $temp;
    $file->save();
  }

  public function parseStudentGrades(){

  }
}
