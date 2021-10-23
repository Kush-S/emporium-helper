<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ZybooksFile;
use Illuminate\Support\Facades\Storage;

class ZybooksFileController extends Controller
{
  public function index()
  {
    $this->parseFile();
    $files = ZybooksFile::select('name')->get();
    return view('zybooks_files')->with('files', $files);
  }

  public function uploadFile(Request $request)
  {
    // Save file name in database
    $file = new ZybooksFile;;
    $file->name = $request->file_name . '.csv';
    $file->save();

    // Save file to project directory
    $zybooks_directory = 'zybooks_files';
    $path = $request->file('zybooks_file_input')->storeAs($zybooks_directory, $request->file_name . '.csv');

    $this->parseFile($request);

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

  public function parseFile()
  {
    $output = shell_exec('python python_scripts/parseZybooks.py python_scripts/zybooks1.csv');
    $output_json = json_decode($output, true);

    foreach ($output_json as $info)
    {
      error_log($info['Last name'] . ' ' . $info['First name'] . ' ' . $info['School email']);
    }
  }
}
