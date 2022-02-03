@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    You are logged in! This will be the welcome page with some helpful information.
                </div>
            </div>
            <a href="{{ route("classroom_index") }}" class="btn btn-primary">View Classrooms</a>
            <button class="btn btn-primary">Create  class</button>
        </div>
    </div>
</div>
@endsection
