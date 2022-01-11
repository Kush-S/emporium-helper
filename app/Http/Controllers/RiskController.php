<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RiskController extends Controller
{
  public function index()
  {
    // $risk = Risk::select('name')->get();

    return view('statistics');
  }
}
