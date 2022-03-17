@extends('layouts.app')

@section('content')
  <div class="container bg-light mb-4 border">
    <div class="row justify-content-center py-2">
      <div class="col-md-6">
        <h2 class="row justify-content-center">Select an instructor</h2>
      </div>
    </div>
    <div class="row justify-content-center pb-4">
      <div class="col-md-6">
        <form method="POST" action="{{ route('settings_add_instructor_submit', Request()->id) }}">
          @csrf
          <table class="table table-hover table-striped table-muted">
            <thead>
              <tr>
                <th scope="col"></th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($nonInstructors as $nonInstructor)
                  <tr>
                    <td><input type="radio" id="{{ $nonInstructor->id }}" name="instructor_id" value="{{ $nonInstructor->id }}"></td>
                    <td><label for="{{ $nonInstructor->id }}">{{ $nonInstructor->name }}</label></td>
                    <td><label for="{{ $nonInstructor->id }}">{{ $nonInstructor->email }}</label></td>
                  </tr>
                @endforeach
            </tbody>
          </table>
          <div class="float-end">
            <a href="{{ route('settings_index', Request()->id) }}" class="btn btn-danger">Cancel</a>
            <button type="submit" class="btn btn-primary">Add instructor</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <x-footer/>
@endsection
