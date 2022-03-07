<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HasClassroomAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
      $user = User::find(Auth::user()->id);
      $classroom_id = $request->id;

      foreach ($user->classrooms as $classroom) {
        if($classroom->id == $classroom_id){
          return $next($request);
        }
      }
      return redirect()->route('classroom_index')->with('status', 'You do not have access to that classroom!');
    }
}
