<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
  public function index()
  {
    return view('zybook_files');
  }

  public function uploadFile(Request $request)
  {
    error_log('@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@');
    $path = $request->file('zybooks_file')->storeAs('zobooks_files', $request->file_name);

    return redirect()->route('files_index');
  }
}
