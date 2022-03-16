<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classroom;
use App\Models\User;

class SettingsController extends Controller
{
  public function index(Request $request)
  {
    $classroom = Classroom::find($request->id);
    $owner = User::find($classroom->owner);

    $instructors = $classroom->users;

    return view('settings')->with('owner', $owner)->with('instructors', $instructors);
  }

  public function add_member()
  {
    return view('add_member');
  }
}
