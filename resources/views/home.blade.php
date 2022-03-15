@extends('layouts.app')

@section('content')
<div class="container pb-4">
    <div class="row">
      <div class="col-md-10 offset-md-1">
        @if (session('status'))
            <div class="alert alert-danger">
                {{ session('status') }}
            </div>
        @endif
        <div class="card">
          <div class="card-header">Home</div>
          <div class="card-body">
            <div class="row justify-content-center pb-2">
              <div class="col-md-2 m-3 text-center">
                <a href="{{ route("classroom_index") }}" class="btn btn-primary p-4 border border-success shadow-md">View Classrooms</a>
              </div>
              <div class="col-md-2 m-3 text-center">
                <a href="{{ route("classroom_create") }}" class="btn btn-primary p-4 border border-success shadow-md">Create Classroom</a>
              </div>
            </div>

              Welcome to the {{ config('app.name', 'Laravel') }} app, {{ Auth::user()->name }}.
              <br>
              <br>
              The purpose of this app is to help instructors see which of their students are at a risk of failing the class by analyzing instructor uploaded zyBooks and Canvas grade files.
          </div>
        </div>
      </div>
    </div>
</div>
<x-footer/>
@endsection
