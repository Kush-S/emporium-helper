@extends('layouts.app')

@section('content')
  <div class="container bg-light border rounded">
    <div class="row">
      <div class="pt-2">
        {{-- <a href="{{ route("statistics_calculate") }}" class="btn btn-danger float-end">Import grades</a> --}}
      </div>
      <div class="p-5 d-flex justify-content-center">
        <h4>Student Risk Statistics</h4>
      </div>
      <div>
        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th scope="col">Name</th>
              <th scope="col">Participation total (max 10)</th>
              <th scope="col">Challenge total (max 40)</th>
              <th scope="col">Lab total (max 50)</th>
              <th scope="col">Total (max 100)</th>
            </tr>
          </thead>

          <tbody>
            @for($i = 1; $i <= 10; $i++)
              <tr>
                <th scope="row"><a href="#">John Doe {{$i}}</a></th>
                <td>{{rand(0,10)}}</td>
                <td>{{rand(0,40)}}</td>
                <td>{{rand(0,50)}}</td>
                <td>{{rand(0,100)}}</td>
              </tr>
            @endfor
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
