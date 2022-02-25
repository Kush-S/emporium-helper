@extends('layouts.app')

@section('content')
  <div class="container mb-3">
      <a href="{{ route('settings_index', Request()->id) }}" class="btn btn-primary">Back</a>

      <div class="container bg-light border rounded">
        test
      </div>
  </div>


@endsection
