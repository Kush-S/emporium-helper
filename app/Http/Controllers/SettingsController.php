<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classroom;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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

    return view('settings')->with('owner', $owner)->with('instructors', $instructors)->with('classroom', $this->classroom);
  }

  public function addInstructor()
  {
    $users = User::orderBy('email')->get()->all();
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

  public function addInstructorSubmit(Request $request)
  {
    $user = User::find($request->instructor_id);

    // Only classroom owner can add instructor
    // if(Auth::user()->id != $this->classroom->owner)
    // {
    //   return redirect()->route('settings_index', $request->id)->with('error', 'Unable to add. Only classroom owner may add an instructor!');
    // }

    $user->classrooms()->attach($request->id);

    return redirect()->route('settings_index', $request->id)->with('status', 'Successfully added ' . $user->name . ' ' . '(' . $user->email . ') to this classroom');
  }

  public function removeInstructor(Request $request)
  {
    $user = User::find($request->instructor_id);

    // Only classroom owner can remove instructor
    // if(Auth::user()->id != $this->classroom->owner)
    // {
    //   return redirect()->route('settings_index', $request->id)->with('error', 'Unable to remove. Only classroom owner may remove an instructor!');
    // }

    $user->classrooms()->detach($request->id);

    return redirect()->route('settings_index', $request->id)->with('status', 'Successfully removed ' . $user->name . ' ' . '(' . $user->email . ') from this classroom');
  }
}
