@extends('layouts.app')

@section('content')

<div class="container mb-4">
  <div class="row">
    <div class="col">
      <div class="float-start h4 bg-dark p-2 rounded text-white">
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

<div class="container bg-light py-5 border mb-2" style="min-height: 550px;">
  <div class="row">
    <div class="col d-flex justify-content-center border-end">
      <div class="col py-5">
        <div class="text-center">
          <form method="POST" class="row p-2" action="{{route('analysis_file', Request()->id)}}">
            @csrf
            <select class="form-select col" name="selected_file">
              @if ($selected_file == "")
                <option disabled selected>No file selected</option>
              @endif

              <option disabled>--zyBooks files--</option>
              @foreach ($zybooks_files as $file)
                <option value="{{ $file->name, $file->type }}" file_type="{{ $file->type, $file->type  }}">{{ $file->name }}</option>
              @endforeach

              <option disabled>--Canvas files--</option>
              @foreach ($canvas_files as $file)
                <option value="{{ $file->name, $file->type  }}" file_type="{{ $file->type, $file->type  }}">{{ $file->name }}</option>
              @endforeach
            </select>
            <button type="submit" class="btn btn-primary col-2">Select</button>
          </form>
        </div>
        <div class="row py-3">
          <div class="text-center h5">
            File selected: <span class="">{{$selected_file}}</span>
          </div>
          <div class="text-center h5">
            {{-- File type: {{ $selected_file->type }} --}}
          </div>
          <div class="text-center h5">
            Total students: {{ rand(10,30) }}
          </div>
          <div class="text-center h5">
            <?php $randRisk =  rand(0,1) ?>
            Students at risk: <span class="{{ $randRisk > 0 ? 'text-danger' : '' }}">{{$randRisk}}</span>
          </div>
        </div>
        <a href="{{ route('analysis_students_list', Request()->id) }}" class="btn btn-primary d-flex justify-content-center p-3 col-4 mx-auto">Student list</a>
      </div>
    </div>
    <div class="col text-center p-4">
      <canvas id="chart2"></canvas>
    </div>
    <div class="col p-4 my-auto">
      <canvas id="chart1"></canvas>
    </div>

  </div>
  {{-- <div class="row" style="height: 300px"> --}}
  <div class="row">

  </div>
</div>
<x-footer/>

<script>
var nums = {!!json_encode($randNums)!!}
console.log(nums)
</script>
<script>
const ctx = document.getElementById('chart1').getContext('2d');
const myChart1 = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Participation', 'Challenge', 'Lab'],
        datasets: [{
            label: [],
            data: [50, 95, 90],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
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
            beginAtZero: true
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
  const labels = ['Chapter 1.csv', 'Chapter 2.csv', 'Chapter 3.csv', 'Chapter 4.csv', 'Chapter 5.csv', 'Chapter 6.csv'];

  const data = {
    labels: [
      'At risk',
      'Not at risk',
    ],
    datasets: [{
      label: 'My First Dataaaaaaaaaaaaaaaaaaaaaaaaset',
      data: [5,20],
      backgroundColor: [
        'rgb(255, 99, 132)',
        'rgb(54, 162, 235)',
        'rgb(255, 205, 86)'
      ],
      hoverOffset: 4
    }]
  };

  const config = {
    type: 'doughnut',
    data: data,
    options: {
      maintainAspectRatio: false,
      title:{
        display: true,
        text: 'test'
      }
    }
  };
</script>
<script>
  const myChart2 = new Chart(
    document.getElementById('chart2'),
    config
  );
</script>

@endsection
