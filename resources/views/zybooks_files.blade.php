@extends('layouts.app')

@section('content')
<x-headers/>
<div class="container bg-light">
  <div class="p-5 d-flex justify-content-center">
    <h4>Upload zyBooks files here. One file for each week.</h4>
  </div>

  <div class="pt-3 d-flex justify-content-center">
    <form method="POST" enctype="multipart/form-data" action="{{ route('files_upload') }}">
      @csrf
      <div class="form-group pb-3">
        <label for="file_name">File Name:</label>
        <input type="text" class="form-control" name="file_name" placeholder="Example: zyBooks week 1" required></input>
        <small id="fileNameHelp" class="form-text text-muted">".csv" will be added to file name automatically.</small>
      </div>
      <div class="form-group pb-3">
        <input type="file" class="form-control-file" name="zybooks_file_input" required>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>

  <div class="py-5">
    @foreach ($files->chunk(5) as $chunk)
      <div class="d-flex justify-content-center">
          @foreach ($chunk as $file)
            <div class="p-2">
              <a class="p-1 border" href="{{route('files_download', $file->name)}}">{{$file->name}}</a>
              <a href="{{route('files_delete', $file->name)}}" type="button" class="btn btn-danger">Delete</a>
            </div>
          @endforeach
        </div>
    @endforeach
  </div>
</div>
@endsection
