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
    <div class="col-3 mb-1 text-center border-bottom">
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
          <form method="POST" class="row p-2" action="{{route('analysis_file_select', Request()->id)}}">
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
                  <option value="{{ $file->name }}" @if($selected_canvas_file == $file->name) selected @endif>{{ $file->name }}</option>
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
            zyBooks file selected: <span class="">{{$selected_zybooks_file}}</span>
          </div>
          <div class="text-center h5">
            Canvas file selected: <span class="">{{$selected_canvas_file}}</span>
          </div>
          <div class="text-center h5">
            Total students: {{$mixClassStats['Student count']}}
          </div>
          <div class="text-center h5">
            Students at risk: <span class="{{ $mixClassStats['At risk'] > 0 ? 'text-danger' : '' }}">{{$mixClassStats['At risk']}}</span>
          </div>
        </div>
        <form method="POST" class="row p-2" action="{{ route('analysis_mix_students_list', Request()->id) }}">
          @csrf
          <input type="hidden" name="selected_zybooks_file" value="{{$selected_zybooks_file}}">
          <input type="hidden" name="selected_canvas_file" value="{{$selected_canvas_file}}">
          <input type="hidden" name="mixStudentData" value="{{ json_encode($mixStudentData, true) }}">
          <input type="hidden" name="mixClassStats" value="{{ json_encode($mixClassStats, true) }}">
          <button type="submit" class="btn btn-primary d-flex justify-content-center p-3 col-4 mx-auto">Student list</button>
        </form>
      </div>
    </div>

    <div class="col-8">
      <div class="row">
        <div class="col-6 text-center p-4 my-auto">
          <canvas id="classPointsChart"></canvas>
        </div>
        <div class="col-6 text-center p-4 my-auto">
          <canvas id="classScoresChart"></canvas>
        </div>
      </div>
      <div class="row">
        <div class="col text-center my-auto">
            <canvas id="atRiskCircleChart"></canvas>
        </div>
        <div class="col text-center my-auto">
            <canvas id="zyBooksChart"></canvas>
        </div>
      </div>
    </div>

  </div>
</div>
<x-footer/>

<script>
  var mixClassStats = {!! json_encode($mixClassStats) !!}
  var studentStats = {!! json_encode($mixStudentData) !!}
</script>

<script>
var bar1 = 0
var bar2 = 0
var bar3 = 0
var bar4 = 0
var bar5 = 0
var bar6 = 0

var subtract = Math.round((mixClassStats["max_points"]/6)/10)*10

var increment6 = Math.round(mixClassStats["max_points"] / 50)*50
var increment5 = increment6 - subtract
var increment4 = increment5 - subtract
var increment3 = increment4 - subtract
var increment2 = increment3 - subtract
var increment1 = increment2 - subtract
console.log(subtract)
console.log(increment6)
console.log(increment5)
console.log(increment4)
console.log(increment3)
console.log(increment2)
console.log(increment1)

for (i = 0; i < Object.keys(studentStats).length; i++) {
  if(studentStats[i]["Final Points"] <= increment1){bar1 += 1}
  else if(studentStats[i]["Final Points"] <= increment2){bar2 += 1}
  else if(studentStats[i]["Final Points"] <= increment3){bar3 += 1}
  else if(studentStats[i]["Final Points"] <= increment4){bar4 += 1}
  else if(studentStats[i]["Final Points"] <= increment5){bar5 += 1}
  else {bar6 += 1}
}

const ctx = document.getElementById('classPointsChart').getContext('2d');
const barChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['0-'+ (increment1 - 1),
                  increment1 + '-' + (increment2 - 1),
                  increment2 + '-' + (increment3 - 1),
                  increment3 + '-' + (increment4 - 1),
                  increment4 + '-' + (increment5 - 1),
                  increment5 + '-' + increment6],
        datasets: [{
            label: [],
            data: [bar1, bar2, bar3,bar4,bar5,bar6],
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
          text: 'Current class points'
        }
      },
      scales: {
          y: {
            beginAtZero: true,
            max: mixClassStats["Student count"],
            title: {
              display: true,
              text: '# of students'
            }
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
var bar1 = 0
var bar2 = 0
var bar3 = 0
var bar4 = 0
var bar5 = 0

var increment1 = 59.9
var increment2 = 69.9
var increment3 = 79.9
var increment4 = 89.9
var increment5 = 100

for (i = 0; i < Object.keys(studentStats).length; i++) {
  if(studentStats[i]["Current Score"] <= increment1){bar1 += 1}
  else if(studentStats[i]["Current Score"] <= increment2){bar2 += 1}
  else if(studentStats[i]["Current Score"] <= increment3){bar3 += 1}
  else if(studentStats[i]["Current Score"] <= increment4){bar4 += 1}
  else if(studentStats[i]["Current Score"] <= increment5){bar5 += 1}
  else {bar5 += 1}
}

const ctx3 = document.getElementById('classScoresChart').getContext('2d');
const barChart2 = new Chart(ctx3, {
    type: 'bar',
    data: {
        labels: ['0-59.9%', '60-69.9%', '70-79.9%', '80-89.9%', '90-100%'],
        datasets: [{
            data: [bar1, bar2, bar3,bar4,bar5],
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
          text: 'Current percentage'
        }
      },
      scales: {
          y: {
            max: mixClassStats["Student count"],
            title: {
              display: true,
              text: '# of students'
            }
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
const ctx4 = document.getElementById('zyBooksChart').getContext('2d');
const barChart3 = new Chart(ctx4, {
    type: 'bar',
    data: {
        labels: ['Participation','Challenge','Lab'],
        datasets: [{
            label: [],
            data: [mixClassStats['Participation average'], mixClassStats['Challenge average'], mixClassStats['Lab average']],
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
          text: 'zyBooks activities (%)'
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
const ctx2 = document.getElementById('atRiskCircleChart').getContext('2d');
const doughnutChart = new Chart(ctx2, {
    type: 'doughnut',
    data: {
        labels: ['At risk', 'Not at risk'],
        datasets: [{
            label: '# of Votes',
            data: [mixClassStats['At risk'], mixClassStats['Student count'] - mixClassStats['At risk']],
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
