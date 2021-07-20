<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use App\Models\File;

class FileController extends Controller
{
  public function index()
  {
    // return view('zybook_files')->with('files', $files);
    return view('zybook_files');

  }

  public function uploadFile(Request $request)
  {
    $file = new File;
    $file->name = $request->file_name;
    $file->save();

    error_log($request->file_name);
    $path = $request->file('zybooks_file')->storeAs('zobooks_files', $request->file_name);

    return redirect()->route('files_index');
  }
}
