@extends('layouts.app')

@section('content')
<x-headers/>
<div class="container">
  <div class="row">
  You are now in:
    {{$classroom->number}}, section {{$classroom->section}}.

    Created in {{$classroom->term}} {{$classroom->year}}
    <div class="row">
      <a href="{{route('statistics_index', Request()->id)}}">test</a>
      Future site of features such as your files and student risk statistics.

    </div>

    <div class="row col-md-2">
      <a href="{{route('classroom_index')}}" class="btn btn-primary">Class list</a>
    </div>
  </div>
</div>
@endsection
