@extends('layouts.app')

@section('content')
<head>
 <meta charset="UTF-8" />
 <meta name="viewport" content="width=device-width, initial-scale=1.0" />
 <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<div class="container mb-3">
  <div class="row">
    <ul class="nav justify-content-center">
      <li class="nav-item">
        <a class="btn {{ Request::path() === 'classroom/' . Request()->id . '/statistics' ? 'btn-dark' : 'btn-secondary'}}" href="{{route('statistics_index', Request()->id)}}">Statistics</a>
      </li>
      <li class="nav-item">
        <a class="btn {{ Request::path() === 'classroom/' . Request()->id . '/files' ? 'btn-dark' : 'btn-secondary'}}" href="{{ route('files_index', Request()->id) }}">Files</a>
      </li>
      <li class="nav-item">
        <a class="btn {{ Request::path() === 'classroom/' . Request()->id . '/settings' ? 'btn-dark' : 'btn-secondary'}}" href="{{ route('settings_index', Request()->id) }}">Settings</a>
      </li>
    </ul>
  </div>
</div>
@endsection
