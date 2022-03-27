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
    $zybooks_files = ZybooksFile
    ::where('classroom_id', $this->classroom->id)
    ->where('type', 'zybooks')->get()->sortBy('name');;

    $canvas_files = ZybooksFile
    ::where('classroom_id', $this->classroom->id)
    ->where('type', 'canvas')->get()->sortBy('name');;

    return view('zybooks_files')->with('zybooks_files', $zybooks_files)->with('canvas_files', $canvas_files)->with('classroom', $this->classroom);
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

    // Update files count
    $this->classroom->files += 1;
    $this->classroom->save();

    // Save file to project directory
    $path = $request
            ->file('input_file')
            ->storeAs($file->classroom_id . '/' . $file->type, $file->name);

    // call parseFile() on uploaded file
    // $this->parseStudentInfo($file);

    return redirect()->route('files_index', $request->id)->with('status', 'File ' . '\'' . $file->name . '\'' . ' uploaded successfully!');
  }

  public function downloadFile($id,$type,$file)
  {
    return Storage::download($id . '/' . $type . '/' . $file);
  }

  public function deleteFile(Request $request)
  {
    // delete from storage
    Storage::delete($this->classroom->id . '/' . $request->type . '/' . $request->file_name);

    // delete from database
    $database_file = ZybooksFile
      ::where('name', $request->file_name)
      ->where('type', $request->type)
      ->where('classroom_id', $this->classroom->id)->first();
    $database_file->delete();

    // Update files count
    $this->classroom->files -= 1;
    $this->classroom->save();

    return redirect()->route('files_index', $this->classroom->id)->with('status', '\'' . $request->file_name . '\'' . ' deleted successfully!');
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
