@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 offset-md-1">
          <div class="mb-2">
          <a href="{{ route("classroom_index") }}" class="btn btn-primary">View Classrooms</a>
          <a href="{{ route("classroom_create") }}" class="btn btn-primary">Create Classroom</a>
          </div>
          <div class="card">
              <div class="card-header">Home</div>
              <div class="card-body">
                  Welcome to the {{ config('app.name', 'Laravel') }} app, {{ Auth::user()->name }}. You are now logged in!
                  <br>
                  <br>
                  This is the <b>Home</b> page, and you may come back here easily from anywhere in the app by clicking the app's name on the top left of each page.

                  <br>
                  <br>
                  The purpose of this web app is to help instructors determine which of their students are at a risk of failing the class.
                  By uploading zyBooks and Canvas .csv grade files, you are able to view statistics and trends of each student's grade,
                  and send them an email through this app if further action is required.
                  <br>
                  <br>
                  To get started, create a classroom by clicking the "Create Classroom" button at the top of this page.
                  A classroom is a separate space for each instructor to upload their own class's grade files and view the statistics of those files.
                  A new classroom is required to be created for each class an instructor may have, and for each new semester as well.
                  If you have already created a classroom before, you may enter it by clicking the "View Classrooms" button above and clicking the "Visit" button beside it.
                  Within a classroom space, you will have navigation buttons near the top of the screen to view class statistics, manage files, and edit settings for that classroom.

              </div>
          </div>

        </div>
    </div>
</div>
@endsection
