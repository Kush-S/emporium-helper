<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ZybooksFile;
use App\Models\Student;
use Config;
use Illuminate\Support\Facades\Storage;

class ZybooksFileController extends Controller
{
  public function index()
  {
    $files = ZybooksFile::select('name')->get();
    return view('zybooks_files')->with('files', $files);
  }

  public function uploadFile(Request $request)
  {
    // Save file name in database
    $file = new ZybooksFile;
    $file->name = $request->file_name . '.csv';
    $file->save();

    // Save file to project directory
    $path = $request->file('zybooks_file_input')
            ->storeAs(Config::get('emporium_variables.storage_directory'), $request->file_name . '.csv');

    // call parseFile() on uploaded file
    $this->parseFile($request->file_name);

    return redirect()->route('files_index');
  }

  public function downloadFile($file)
  {
    return Storage::download('zybooks_files/' . $file);
  }

  public function deleteFile($file)
  {
    Storage::delete('zybooks_files/' . $file);

    $database_file = ZybooksFile::where('name', $file)->first();
    $database_file->delete();

    return redirect()->route('files_index');
  }

  public function parseFile($file_name)
  {
    // clean file_name in case of spaces, etc.
    $file_name = escapeshellarg($file_name);

    // build and run python command
    $shell_command = "python python_scripts/parseZybooks.py ../storage/app/zybooks_files/" . $file_name . ".csv";
    $output = shell_exec($shell_command);

    // decode output from python to JSON
    $output_json = json_decode($output, true);

    // store each student, if already not stored
    foreach ($output_json as $info)
    {
      $student = Student::firstOrCreate([
        'first_name' => $info['First name'],
        'last_name' => $info['Last name'],
        'email' => $info['Primary email']
      ]);
    }
  }
}
