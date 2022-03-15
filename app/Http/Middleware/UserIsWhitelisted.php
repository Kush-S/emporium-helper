<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserIsWhitelisted
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
      $emails = explode("\r\n", file_get_contents(base_path('whitelist.txt'), true));

      if(!in_array(auth()->user()->email, $emails)) {
        return redirect()->route('dashboard')->with('status', 'Email \'' . auth()->user()->email . '\' is not whitelisted. Please contact BGSU IT.');
      }

      return $next($request);
    }
}
