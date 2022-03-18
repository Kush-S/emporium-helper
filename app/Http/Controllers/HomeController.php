<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function indexFooterAbout()
    {
        return view('footer_about');
    }

    public function indexFooterCredits()
    {
        return view('footer_credits');
    }

    public function indexFooterTutorial()
    {
        return view('footer_tutorial');
    }
}
