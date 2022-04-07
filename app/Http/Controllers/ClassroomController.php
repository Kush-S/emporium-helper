<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classroom;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ClassroomController extends Controller
{
  public function index()
  {
    $user = User::find(Auth::user()->id);
    $classrooms = $user->classrooms()->get()->sortByDesc('year');

    return view('classrooms_list')->with('classrooms', $classrooms);
  }

  public function create()
  {
    return view('classroom_create');
  }

  public function saveClassroom(Request $request)
  {
    $user = User::find(Auth::user()->id);

    $classroom = new Classroom;
    $classroom->term = $request->class_term;
    $classroom->number = $request->class_number;
    $classroom->section = $request->class_section;
    $classroom->year = $request->class_year;
    $classroom->owner = $user->id;
    if ($classroom->section == NULL) {$classroom->section = ' ';}

    // selected files JSON object
    $selected_files["zybooks"] = "None";
    $selected_files["canvas"] = "None";
    $classroom->files_selected = $selected_files;

    // zybooks calculation variables JSON object
    $variablesZybooks["participation_m"] = -1.06285;
    $variablesZybooks["participation_b"] = 124.03443;
    $variablesZybooks["participation_weight"] = 20;
    $variablesZybooks["challenge_m"] = -0.94222;
    $variablesZybooks["challenge_b"] = 108.15462;
    $variablesZybooks["challenge_weight"] = 20;
    $variablesZybooks["lab_m"] = -0.92121;
    $variablesZybooks["lab_b"] = 104.09236;
    $variablesZybooks["lab_weight"] = 1.19;
    $jsonArray["zybooks"] = $variablesZybooks;

    // canvas calculation variables JSON object
    $variablesCanvas["risk_weight"] = 100;
    $jsonArray["canvas"] = $variablesCanvas;

    // zybooks calculation variables JSON object
    $variablesMix["participation_m"] = -1.06285;
    $variablesMix["participation_b"] = 124.03443;
    $variablesMix["participation_weight"] = 20;
    $variablesMix["challenge_m"] = -0.94222;
    $variablesMix["challenge_b"] = 108.15462;
    $variablesMix["challenge_weight"] = 20;
    $variablesMix["lab_m"] = -0.92121;
    $variablesMix["lab_b"] = 104.09236;
    $variablesMix["lab_weight"] = 1.19;
    $jsonArray["mix"] = $variablesMix;

    $classroom->risk_variables = $jsonArray;

    $classroom->email_template = "Dear student\n\n\tThis email is to notify you that your performance in this class is at risk. Please work with your instructor or TA to improve your standing in this class.\n\nzyCat App";
    $classroom->students_notified = [];
    $classroom->save();

    // save the many-to-many relationship
    $user->classrooms()->attach($classroom->id);

    return redirect()->route('analysis_index', $classroom->id)->with('status', 'Successfully created ' . $classroom->number . ' for ' . $classroom->term . ' ' . $classroom->year . '!');
  }

  public function searchIndex(Request $request)
  {
    $searchdata['term'] = $request->term;
    $searchdata['year'] = $request->year;
    $searchdata['number'] = $request->number;
    $searchdata['section'] = $request->section;

    $classrooms = Auth::user()->classrooms()
    ->where('year', 'LIKE', '%' . $request->year . '%')
    ->where('term', 'LIKE', '%' . $request->term . '%')
    ->where('number', 'LIKE', '%' . $request->number . '%')
    ->where('section', 'LIKE', '%' . $request->section . '%')
    ->get();
    return view('classroom_search')->with('classrooms', $classrooms)->with('searchdata', $searchdata);
  }
}
