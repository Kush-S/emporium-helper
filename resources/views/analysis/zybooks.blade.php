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

<div class="container bg-light py-5 border mb-5" style="min-height: 550px;">
  <div class="row">
    <div class="col-4 d-flex justify-content-center border-end">
      <div class="col py-5">
        <div class="text-center">
          <form method="POST" class="row p-2" action="{{route('analysis_file', Request()->id)}}">
            @csrf
            <label class="col-4 col-form-label">zyBooks Files:</label>
            <div class="col-8">
              <select class="form-select mb-2" name="selected_zybooks_file">
                <option>None</option>
                @foreach ($zybooks_files as $file)
                  <option value="{{ $file->name }}" @if($selected_zybooks_file == $file->name) selected @endif>{{ $file->name }}</option>
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
              <button type="submit" class="btn btn-primary float-end">Load files</button>
            </div>
          </form>
        </div>
        <div class="row py-3">
          <div class="text-center h5">
            zyBooks file selected: <span class="">{{$selected_zybooks_file}}</span>
          </div>
          <div class="text-center h5">
            Canvas file selected: <span class="">{{$selected_canvas_file}}</span>
          </div>
          <div class="text-center h5">
            Total students: {{ $zybooksClassStats['Student count'] }}
          </div>
          <div class="text-center h5">
            Students at risk: <span class="{{ $zybooksClassStats['Student count'] > 0 ? 'text-danger' : '' }}">{{ $zybooksClassStats['At risk'] }}</span>
          </div>
        </div>
        <form method="POST" class="row p-2" action="{{ route('analysis_students_list', Request()->id) }}">
          @csrf
          <input type="hidden" id="custId" name="zybooksStudentData" value="{{ json_encode($zybooksStudentData, true) }}">
          <button type="submit" class="btn btn-primary d-flex justify-content-center p-3 col-4 mx-auto">Student list</button>
        </form>
      </div>
    </div>

    <div class="col-4 text-center my-auto">
        <canvas id="chart2"></canvas>
    </div>
    <div class="col-4 text-center p-4 my-auto">
      <canvas id="chart1"></canvas>
    </div>

  </div>
</div>
<x-footer/>

<script>
  var zybooksClassStats = {!! json_encode($zybooksClassStats) !!}
  console.log(zybooksClassStats)
</script>

<script>
const ctx = document.getElementById('chart1').getContext('2d');
const barChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Participation', 'Challenge', 'Lab'],
        datasets: [{
            label: [],
            data: [zybooksClassStats['Participation average'], zybooksClassStats['Challenge average'], zybooksClassStats['Lab average']],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
            ],
            borderWidth: 1
        }]
    },
    options: {
      plugins: {
        legend: {
          display: false,
        },
        title: {
          display: true,
          text: 'Average scores (%)'
        }
      },
      scales: {
          y: {
            beginAtZero: true,
            max: 100
          },
          x: {
            ticks: {
              minRotation: 0
            }
          }
      }
    }
});
</script>

<script>
const ctx2 = document.getElementById('chart2').getContext('2d');
const doughnutChart = new Chart(ctx2, {
    type: 'doughnut',
    data: {
        labels: ['At risk', 'Not at risk'],
        datasets: [{
            label: '# of Votes',
            data: [zybooksClassStats['At risk'], zybooksClassStats['Student count']],
            backgroundColor: [
              'rgb(255, 99, 132)',
              'rgb(54, 162, 235)',
              'rgb(255, 205, 86)'
            ],
            hoverOffset: 4
        }]
    },
    options: {
      maintainAspectRatio: false,
      title:{
        display: true,
        text: 'test'
      }
    }
});
</script>

@endsection
