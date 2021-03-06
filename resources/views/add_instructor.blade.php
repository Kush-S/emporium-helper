@extends('layouts.app')

@section('content')
  <div class="container bg-light mb-4 border" style="min-height: 640px;">
    <div class="row justify-content-center py-2">
      <div class="col-md-6">
        @if (session('status'))
          <div class="alert alert-success">
            {{ session('status') }}
          </div>
        @endif
        @if (session('error'))
          <div class="alert alert-danger">
            {{ session('error') }}
          </div>
        @endif
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
              @empty($nonInstructors)
                <td></td>
                <td>No instructors available to add!</td>
                <td></td>
              @endempty
              @foreach ($nonInstructors as $nonInstructor)
                <tr class="cards">
                  <td><input type="radio" id="{{ $nonInstructor->id }}" name="instructor_id" value="{{ $nonInstructor->id }}"></td>
                  <td><label for="{{ $nonInstructor->id }}">{{ $nonInstructor->name }}</label></td>
                  <td><label for="{{ $nonInstructor->id }}">{{ $nonInstructor->email }}</label></td>
                </tr>
              @endforeach
            </tbody>
          </table>
          <div class="float-end">
            <a href="{{ route('settings_index', Request()->id) }}" class="btn btn-danger">Cancel</a>
            @empty($nonInstructors)
              <button type="submit" class="btn btn-primary" disabled>Add instructor</button>
            @else
              <button type="submit" class="btn btn-primary">Add instructor</button>
            @endempty
          </div>
        </form>
      </div>
    </div>
  </div>
  <x-footer/>
@endsection
