@extends('layouts.app')

@section('content')
<div class="container pb-4" style="min-height: 640px;">
    <div class="row">
        <div class="col-md-10 offset-md-1">
          @if (session('status'))
              <div class="alert alert-danger">
                  {{ session('status') }}
              </div>
          @endif
          <div class="card">
              <div class="card-header">
                <div class="float-start">Classes</div>
                <a href="{{ route("classroom_search_index") }}" class="float-end">Search <i class="bi bi-search fas fa-2x"></i></a>
              </div>

              <div class="card-body">
                @foreach ($classrooms->chunk(4) as $chunk)
                  <div class="row pb-4">
                    @foreach ($chunk as $classroom)
                      <div class="col-sm-3">
                        <a style="text-decoration:none;" href="{{ route("analysis_index", $classroom->id) }}">
                        <div class="card text-white cards">
                          <div class="card-header text-white color-orange">
                            {{ $classroom->number }} -
                            @if ($classroom->term == 'Spring')
                              Sp'
                            @elseif ($classroom->term == 'Fall')
                              Fa'
                            @elseif ($classroom->term == 'Summer')
                              Su'
                            @endif
                             {{ substr($classroom->year, -2) }}
                          </div>
                          <div class="card-body bg-dark">
                            <div>
                              Section:
                              @if ($classroom->section == ' ')
                                -
                              @else
                                {{ $classroom->section }}
                              @endif
                            </div>
                            <div>
                              Files: {{ rand(0,10) }}
                            </div>
                            <div>
                              <?php $randRisk =  rand(0,5) ?>
                              At risk: <span class="{{ $randRisk > 0 ? 'text-danger' : 'text-white' }}">{{$randRisk}}</span>
                            </div>
                          </div>
                        </div>
                        </a>
                      </div>
                    @endforeach
                  </div>
                @endforeach

                @if($classrooms == '[]')
                  No classrooms found for your account. <a href="{{ route('classroom_create') }}">Click here</a> to create a classroom.
                @endif
              </div>
          </div>
        </div>
    </div>
</div>
<x-footer/>
@endsection
