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
                  @foreach ($classrooms->chunk(6) as $chunk)
                    <div class="row pb-4">
                      @foreach ($chunk as $classroom)
                        <div class="col-sm-2">
                          <a style="text-decoration:none;" href="{{ route("statistics_index", $classroom->id) }}">
                          <div class="card text-white bg-secondary cards">
                            <div class="card-header text-white bg-dark mb-3">
                              {{ $classroom->number }}
                            </div>
                            <div class="card-body">
                              {{ $classroom->term }}
                              {{ $classroom->year }}<br>
                              Section: {{ $classroom->section }}<br>
                              Files: {{ rand(0,10) }}<br>
                              Students at risk: {{rand(0,5)}}
                            </div>
                          </div>
                          </a>
                        </div>
                      @endforeach
                    </div>
                  @endforeach
                  {{-- <table class="table table-striped table-hover">
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
                  </table> --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
