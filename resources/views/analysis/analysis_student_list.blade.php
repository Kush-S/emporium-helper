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
              <th scope="col">Current risk</th>
              <th scope="col">Participation</th>
              <th scope="col">Lab</th>
              <th scope="col">Challenge</th>
            </tr>
          </thead>

          <tbody>
            @for($i = 1; $i <= 10; $i++)
              <tr>
                <div class="">
                  <td scope="row"><a href="{{ route('analysis_student_info', Request()->id) }}">John Doe {{$i}}</a></td>
                  <td>{{10 - $i}}%</td>
                  <td>{{rand(80,100)}}%</td>
                  <td>{{rand(80,100)}}%</td>
                  <td>{{rand(80,100)}}%</td>
                </div>
              </tr>
            @endfor
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>

<x-footer/>
@endsection
