<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classroom;

class ClassroomController extends Controller
{
  public function index()
  {
    $classrooms = Classroom::all();

    return view('classrooms')->with('classrooms', $classrooms);
  }
}
