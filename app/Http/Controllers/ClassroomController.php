<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classroom;

class ClassroomController extends Controller
{
  public function index()
  {
    $classrooms = Classroom::all()->sortByDesc('year');

    return view('classrooms_list')->with('classrooms', $classrooms);
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
    $classroom->year = $request->class_year;
    $classroom->save();

    return redirect()->route('analysis_index', $classroom->id);
  }

  public function searchIndex(Request $request)
  {
    $searchdata['term'] = $request->term;
    $searchdata['year'] = $request->year;
    $searchdata['number'] = $request->number;
    $searchdata['section'] = $request->section;
    error_log($searchdata['term']);

    $classrooms = Classroom::
    where('year', 'LIKE', '%' . $request->year . '%')
    ->where('term', 'LIKE', '%' . $request->term . '%')
    ->where('number', 'LIKE', '%' . $request->number . '%')
    ->where('section', 'LIKE', '%' . $request->section . '%')
    ->get();
    return view('classroom_search')->with('classrooms', $classrooms)->with('searchdata', $searchdata);
  }
}
