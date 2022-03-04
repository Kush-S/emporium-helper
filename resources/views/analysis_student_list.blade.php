@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="pb-2">
      <a href="{{ route('analysis_index', Request()->id) }}" class="btn btn-primary">Back to analysis</a>
    </div>
  </div>
  <div class="container bg-light border rounded">
    <div class="row">
      <div class="p-5 d-flex justify-content-center">
        <h4>Student Risk Statistics</h4>
      </div>
      <div>
        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th scope="col">Name</th>
              <th scope="col">Current risk</th>
            </tr>
          </thead>

          <tbody>
            @for($i = 1; $i <= 10; $i++)
              <tr>
                <th scope="row"><a href="{{ route('analysis_student_info', Request()->id) }}">John Doe {{$i}}</a></th>
                <td>{{rand(0,10)}}%</td>
              </tr>
            @endfor
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
