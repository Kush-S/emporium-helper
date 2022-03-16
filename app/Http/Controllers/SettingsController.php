<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classroom;
use App\Models\User;

class SettingsController extends Controller
{
  public function __construct(Request $request)
  {
    $this->classroom = Classroom::find($request->id);
  }

  public function index()
  {
    $owner = User::find($this->classroom->owner);
    $instructors = $this->classroom->users;

    return view('settings')->with('owner', $owner)->with('instructors', $instructors);
  }

  public function addInstructor()
  {
    $users = User::all();
    $instructors = $this->classroom->users;
    $nonInstructors = [];

    foreach($users as $user)
    {
      if(!$instructors->contains($user))
      {
        array_push($nonInstructors, $user);
      }
    }

    return view('add_instructor')->with('nonInstructors', $nonInstructors);
  }
}
