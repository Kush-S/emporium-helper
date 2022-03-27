@extends('layouts.app')

@section('content')

<div class="container mb-4">
  <div class="row">
    <div class="col">
      <div class="float-start h4">
        {{ $classroom->number }}
        (@if ($classroom->term == 'Spring')Sp'
        @elseif ($classroom->term == 'Fall')Fa'
        @elseif ($classroom->term == 'Summer')Su'
        @endif
        {{ substr($classroom->year, -2) }})
      </div>
      <div class="float-end">
        <x-headers/>
      </div>
    </div>
    {{-- <div class="col">

    </div> --}}
  </div>
</div>


<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      @if (session('status'))
        <div class="alert alert-success">
          {{ session('status') }}
        </div>
      @endif
      @if (session('error'))
        <div class="alert alert-danger">
          {{ session('error') }}
        </div>
      @endif
    </div>
  </div>
</div>

{{-- <div class="container d-flex justify-content-center ">
  <div class="row">
    <div class="pt-1 h4 pb-2 text-white bg-info rounded-pill">
      {{ $classroom->number }}
      (@if ($classroom->term == 'Spring')Sp'
      @elseif ($classroom->term == 'Fall')Fa'
      @elseif ($classroom->term == 'Summer')Su'
      @endif
      {{ substr($classroom->year, -2) }})
    </div>
  </div>
</div> --}}

<div class="container bg-light border rounded mb-5" style="min-height: 500px;">
  <div class="row p-2 text-center">
      <h4>Upload zyBooks and Canvas grade files here</h4>
  </div>

  <div class="py-2 d-flex justify-content-center ps-5 ms-5">
    <form method="POST" enctype="multipart/form-data" action="{{ route('files_upload', Request()->id) }}">
      @csrf
      <div class="form-group pb-3">
        <input type="file" class="form-control-file" name="input_file" required>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="type" value="zybooks" checked>
        <label class="form-check-label" for="exampleRadios1">zyBooks file</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="type" value="canvas">
        <label class="form-check-label" for="exampleRadios2">Canvas grade file</label>
      </div>
      <button type="submit" class="btn btn-primary mt-2">Upload</button>
    </form>
  </div>

  {{-- <div class="py-5">
    @foreach ($files->chunk(5) as $chunk)
      <div class="d-flex justify-content-center">
          @foreach ($chunk as $file)
            <div class="p-2">
              <a class="p-1 border" href="{{route('files_download', $file->name, Request()->id)}}">{{$file->name}}</a>
              <a href="{{route('files_delete', $file->name)}}" type="button" class="btn btn-danger">Delete</a>
            </div>
          @endforeach
        </div>
    @endforeach
  </div> --}}

  {{-- <div class="pt-5 d-flex justify-content-center">
    zyBooks files | Canvas files
  </div> --}}

  <div class="row py-2 border-top">
    <div class="col-5 mx-auto">
      <div class="text-center h4">zyBooks files</div>
      @foreach($zybooks_files as $file)
        <div class="input-group input-group-lg cards">
          <form method="POST" action="{{ route('files_delete', Request()->id) }}">
            @csrf
            <input type="hidden" name="file_name" value="{{$file->name}}">
            <input type="hidden" name="type" value="zybooks">
            <button type="submit" class="input-group-text p-2" style="height: 100%;"><i class="bi bi-trash"></i></button>
          </form>
          <a href="{{ route('files_download', [Request()->id, $file->type, $file->name]) }}" class="bg-white form-control p-2 px-5 text-center text-decoration-none text-black">
            <div class="">{{ $file->name }}</div>
          </a>
        </div>
      @endforeach
    </div>

    <div class="col-5 mx-auto">
      <div class="text-center h4">Canvas grade files</div>
      @foreach($canvas_files as $file)
        <div class="input-group input-group-lg cards">
          <form method="POST" action="{{ route('files_delete', Request()->id) }}">
            @csrf
            <input type="hidden" name="file_name" value="{{$file->name}}">
            <input type="hidden" name="type" value="canvas">
            <button type="submit" class="input-group-text p-2" style="height: 100%;"><i class="bi bi-trash"></i></button>
          </form>
          <a href="{{ route('files_download', [Request()->id, $file->type, $file->name]) }}" class="bg-white form-control p-2 px-5 text-center text-decoration-none text-black">
            <div class="">{{ $file->name }}</div>
          </a>
        </div>
      @endforeach
    </div>
  </div>

</div>
<x-footer/>

@endsection
