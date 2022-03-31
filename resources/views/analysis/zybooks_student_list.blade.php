@extends('layouts.app')

@section('content')
<div class="container border rounded my-5">
  <div class="row">
    <a href="{{ route('analysis_index', Request()->id) }}" class="btn btn-primary col-2 m-2">Back to analysis</a>
  </div>
  <div class="row">
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
    <div class="text-center">
      <div class="h4 text-black p-2 rounded">
        zyBooks file selected: {{ $selected_zybooks_file }}
      </div>
    </div>
    <div class="row">
      <div class="col-8 mx-auto">
        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th scope="col">Name</th>
              <th scope="col">Primary Email</th>
              <th scope="col">Current risk</th>
              <th scope="col">Participation</th>
              <th scope="col">Challenge</th>
              <th scope="col">Lab</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($zybooksStudentData as $student)
              <tr>
                <div>
                  @php $i = 0; @endphp
                  <form method="POST" enctype="multipart/form-data" action="{{ route('analysis_zybooks_student_info', Request()->id) }}">
                    @csrf
                    {{-- @foreach ($student as $data)
                      <input type="hidden" name="result{{$i}}" value="{{$data}}">
                      @php $i++; @endphp
                    @endforeach --}}
                    <input type="hidden" name="selected_zybooks_file" value="{{$selected_zybooks_file}}">
                    <input type="hidden" name="last_name" value="{{$student['Last name']}}">
                    <input type="hidden" name="first_name" value="{{$student['First name']}}">
                    <input type="hidden" name="primary_email" value="{{$student['Primary email']}}">
                    <input type="hidden" name="school_email" value="{{$student['School email']}}">
                    <input type="hidden" name="risk" value="{{$student['Risk']}}">
                    <input type="hidden" name="participation_total" value="{{$student['Participation total']}}">
                    <input type="hidden" name="challenge_total" value="{{$student['Challenge total']}}">
                    <input type="hidden" name="lab_total" value="{{$student['Lab total']}}">
                    <td><button type="submit" class="btn btn-link" formtarget="_blank">{{ $student['First name']}} {{ $student['Last name']}}</button></td>
                  </form>
                  <td>{{ $student['Primary email']}}</td>
                  <td class="{{ $student['Risk'] > 30 ? 'text-danger h5' : '' }}">{{ $student['Risk']}}%</td>
                  <td>{{ $student['Participation total']}}</td>
                  <td>{{ $student['Challenge total']}}</td>
                  <td>{{ $student['Lab total']}}</td>
                </div>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<x-footer/>
@endsection
