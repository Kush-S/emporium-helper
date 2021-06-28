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
    $path = $request->file('file_1')->storeAs('myfile123', 'thisisthefilename');
    return view('zybook_files');
  }
}
