<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ZybooksFile;
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
    $file = new ZybooksFile;;
    $file->name = $request->file_name;
    $file->save();

    $path = $request->file('zybooks_file')->storeAs('zybooks_files', $request->file_name);

    return redirect()->route('files_index');
  }

  public function downloadFile($file)
  {
    return Storage::download('zybooks_files/' . $file);
  }
}
