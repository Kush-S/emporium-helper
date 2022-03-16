<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class WhitelistedForRegistering
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
      $emails = explode("\n", file_get_contents(base_path('whitelist.txt'), true));

      for($i = 0; $i < count($emails); $i++)
      {
        $emails[$i] = trim($emails[$i]);
      }

      if(!in_array($request->email, $emails)) {
        return redirect()->route('register')->with('status', 'Email \'' . $request->email . '\' is not whitelisted. Please contact BGSU IT. List is: ' . $emails[0] . ' and ');
      }

      return $next($request);
    }
}
