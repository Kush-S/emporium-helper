@extends('layouts.app')

@section('content')
<div class="container border rounded my-5">
  <div class="row">
    <a href="{{ route('analysis_index', Request()->id) }}" class="btn btn-primary col-2 m-2 float-start">Back to analysis</a>
    <div class="text-center">
      <div class="h4 text-black p-2 rounded">
        Student Risk Statistics - {{ $classroom->number }}
        (@if ($classroom->term == 'Spring')Sp'
        @elseif ($classroom->term == 'Fall')Fa'
        @elseif ($classroom->term == 'Summer')Su'
        @endif
        {{ substr($classroom->year, -2) }})
      </div>
    </div>
  </div>
  <div class="text-center">
    <div class="h4 text-black p-2 rounded">
      Canvas file selected: {{ $selected_canvas_file }}
    </div>
  </div>
  <div class="row">
    <div class="col-8 mx-auto">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th scope="col">Name</th>
            <th scope="col">SIS Login ID</th>
            {{-- <th scope="col">Current risk</th> --}}
            <th scope="col">Current points</th>
            <th scope="col">Current score (%)</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($canvasStudentData as $student)
            <tr>
              <div>
                @php $i = 0; @endphp
                <form method="POST" enctype="multipart/form-data" action="{{ route('analysis_canvas_student_info', Request()->id) }}">
                  @csrf
                  <input type="hidden" name="selected_canvas_file" value="{{$selected_canvas_file}}">
                  <input type="hidden" name="student_name" value="{{$student['Student name']}}">
                  <input type="hidden" name="student_id" value="{{$student['SIS Login ID']}}">
                  <input type="hidden" name="risk" value="{{$student['Risk']}}">
                  <input type="hidden" name="final_points" value="{{$student['Final Points']}}">
                  <input type="hidden" name="current_score" value="{{$student['Current Score']}}">
                  <input type="hidden" name="canvasClassStats" value="{{ json_encode($canvasClassStats, true) }}">
                  <input type="hidden" name="canvasStudentData" value="{{ json_encode($canvasStudentData, true) }}">
                  <td><button type="submit" class="btn btn-link" formtarget="_blank">{{ $student['Student name']}}</button></td>
                </form>
                <td>{{ $student['SIS Login ID']}}</td>
                {{-- <td class="{{ $student['Risk'] > 30 ? 'text-danger h5' : '' }}">{{ $student['Risk']}}%</td> --}}
                <td>{{ $student['Final Points']}}</td>
                <td>{{ $student['Current Score']}}%</td>
              </div>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
<x-footer/>
@endsection
