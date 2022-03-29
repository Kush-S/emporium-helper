@extends('layouts.app')

@section('content')

<div class="container border rounded my-5">
  <div class="row">
    <a href="{{ route('analysis_index', Request()->id) }}" class="btn btn-primary col-2 m-2">Back to analysis</a>
  </div>
  <div class="row">
    <div class="text-center">
      <h4>Student Risk Statistics</h4>
    </div>

    <div class="row">
      <div class="col-6 mx-auto">
        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th scope="col">Name</th>
              <th scope="col">Primary Email</th>
              <th scope="col">Current risk</th>
              <th scope="col">Participation</th>
              <th scope="col">Challenge</th>
              <th scope="col">Lab</th>
            </tr>
          </thead>

          <tbody>
            @foreach ($zybooksStudentData as $student)
              <tr>
                <div>
                  <td>{{ $student['First name']}} {{ $student['Last name']}}</td>
                  <td>{{ $student['Primary email']}}</td>
                  <td class="{{ $student['Risk'] > 30 ? 'text-danger h5' : '' }}">{{ $student['Risk']}}</td>
                  <td>{{ $student['Participation total']}}</td>
                  <td>{{ $student['Challenge total']}}</td>
                  <td>{{ $student['Lab total']}}</td>
                </div>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>

<x-footer/>
@endsection
