@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="card">
                <div class="card-header">
                  <div class="float-start">Classes</div>
                  <a href="{{ route("classroom_search_index") }}" class="float-end">Search <i class="bi bi-search fas fa-2x"></i></a>
                </div>
                <div class="card-body">
                  <table class="table table-striped table-hover">
                    <thead>
                      <tr>
                        <th scope="col">Term</th>
                        <th scope="col">Year</th>
                        <th scope="col">Number</th>
                        <th scope="col">Section</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($classrooms as $classroom)
                          <tr>
                            <td>{{ $classroom->term }}</td>
                            <td>{{ $classroom->year }}</td>
                            <td>{{ $classroom->number }}</td>
                            <td>{{ $classroom->section }}</td>
                            <td><a href="{{ route("classroom_enter", $classroom->id) }}">Visit</a></td>
                          </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
