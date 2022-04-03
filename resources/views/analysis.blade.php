@extends('layouts.app')

@section('content')

{{-- Class title and year --}}
<div class="container mb-4">
  <div class="row">
    <div class="col">
      <div class="float-start h4 text-black p-2 rounded">
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
  </div>
</div>

{{-- Status and error messages --}}
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

<div class="container bg-light pb-5 border mb-5" style="min-height: 550px;">
  <div class="row justify-content-center p-2">
    <div class="col-4 text-center border rounded-pill">
      <div class="h4">Risk Analysis</div>
    </div>
  </div>
  <div class="row">
    <div class="col-4 d-flex justify-content-center border-end">
      <div class="col py-2">
        <div class="text-center">
          <div class="py-2 h4">
            Select files to analyze, or upload files in the "Files" tab
          </div>
          <form method="POST" class="row p-2" action="{{route('analysis_file', Request()->id)}}">
            @csrf
            <label class="col-4 col-form-label">zyBooks Files:</label>
            <div class="col-8">
              <select class="form-select mb-2" name="selected_zybooks_file">
                <option selected>None</option>
                @foreach ($zybooks_files as $file)
                  <option value="{{ $file->name }}">{{ $file->name }}</option>
                @endforeach
              </select>
            </div>

            <label class="col-4 col-form-label">Canvas Files:</label>
            <div class="col-8">
              <select class="form-select mb-2" name="selected_canvas_file">
                <option selected>None</option>
                @foreach ($canvas_files as $file)
                  <option value="{{ $file->name }}">{{ $file->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="">
              <button type="submit" class="btn btn-primary float-end">Analyze</button>
            </div>
          </form>
        </div>
        <div class="row py-3">
          <div class="text-center h5">
            zyBooks file selected: <span class="">-</span>
          </div>
          <div class="text-center h5">
            Canvas file selected: <span class="">-</span>
          </div>
          <div class="text-center h5">
            Total students: -
          </div>
          <div class="text-center h5">
            Students at risk: <span class="">-</span>
          </div>
        </div>
        <button disabled class="btn btn-primary d-flex justify-content-center p-3 col-4 mx-auto">Student list</button>
      </div>
    </div>

    <div class="col-4 text-center my-auto">
        <div class="">Select a file to view these graphs.</div>
    </div>
    <div class="col-4 text-center my-auto">
        <div class="">Select a file to view these graphs.</div>
    </div>

  </div>
</div>
<x-footer/>
@endsection
