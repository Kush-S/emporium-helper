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

  public function create()
  {
    return view('classroom_create');
  }

  public function saveClassroom(Request $request)
  {
    error_log($request->class_term);
    error_log($request->class_number);
    error_log($request->class_section);

    $classroom = new Classroom;
    $classroom->term = $request->class_term;
    $classroom->number = $request->class_number;
    $classroom->section = $request->class_section;
    $classroom->save();

    return redirect()->route('classroom_create');
  }
}
