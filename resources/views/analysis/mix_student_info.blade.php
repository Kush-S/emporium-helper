@extends('layouts.app')

@section('content')
<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>

<div class="container bg-light border rounded mt-4 mb-5" style="min-height: 550px;">
  <div class="row">
    <div class="col">
      <div class="text-center h4">
        <div class="h4 text-black p-2 rounded">
          {{ $classroom->number }}
          (@if ($classroom->term == 'Spring')Sp'
          @elseif ($classroom->term == 'Fall')Fa'
          @elseif ($classroom->term == 'Summer')Su'
          @endif
          {{ substr($classroom->year, -2) }})
        </div>
      </div>
      <div class="text-center h4">
        <span class="text-decoration-underline">Name:</span>
        <span class="">{{$studentData['student_name']}}</span>
      </div>
      <div class="text-center h4">
        <span class="text-decoration-underline">SIS Login ID:</span>
        <span class="">{{$studentData['student_id']}}</span>
      </div>
      <div class="text-center h4">
        <span class="text-decoration-underline">zyBooks file selected:</span>
        <span class="">{{$selected_zybooks_file}}</span>
      </div>
      <div class="text-center h4">
        <span class="text-decoration-underline">Canvas file selected:</span>
        <span class="">{{$selected_canvas_file}}</span>
      </div>
      <div class="text-center h4">
        <span class="text-decoration-underline">Current points:</span>
        <span>{{$studentData['final_points']}}</span>
      </div>
      <div class="text-center h4">
        <span class="text-decoration-underline">Current score:</span>
        <span class="{{ $studentData['current_score'] < 70 ? 'text-danger' : '' }}">{{$studentData['current_score']}}%</span>
      </div>
    </div>
    <div class="col m-auto">
      <div class="pt-2 text-center">
        <div class="my-1">
          Send {{$studentData['student_name']}} an email notification
        </div>
        <div class="mb-1">
          <form method="POST" enctype="multipart/form-data" action="{{ route('analysis_email_student', Request()->id) }}">
            @csrf
            <input type="hidden" name="studentName" value="{{$studentData['student_name']}}">
            <input type="hidden" name="classNumber" value="{{$classroom->number}}">
            <input type="hidden" name="studentEmailName" value="{{$studentData['student_id']}}">
            <button class="btn btn-danger">Notify</button>
          </form>
        </div>
        <label for="exampleInputEmail1" class="form-label">*email template can be set in settings</label>
      </div>
    </div>

  </div>
  <div class="row pt-4">
    <div class="col-6 text-center p-4 border">
      <canvas id="classPointsChart"></canvas>
    </div>
    <div class="col-6 text-center p-4 border">
      <canvas id="classScoresChart"></canvas>
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

var increment1 = mixClassStats["max_points"] / 6
increment1 = Math.round(increment1 * 100) / 100
var increment2 = increment1 + mixClassStats["max_points"] / 6
increment2 = Math.round(increment2 * 100) / 100
var increment3 = increment2 + mixClassStats["max_points"] / 6
increment3 = Math.round(increment3 * 100) / 100
var increment4 = increment3 + mixClassStats["max_points"] / 6
increment4 = Math.round(increment4 * 100) / 100
var increment5 = increment4 + mixClassStats["max_points"] / 6
increment5 = Math.round(increment5 * 100) / 100
var increment6 = increment5 + mixClassStats["max_points"] / 6
increment6 = Math.round(increment6 * 100) / 100

for (i = 0; i < Object.keys(studentStats).length; i++) {
  if(studentStats[i]["Final Points"] <= increment1){bar1 += 1}
  else if(studentStats[i]["Final Points"] <= increment2){bar2 += 1}
  else if(studentStats[i]["Final Points"] <= increment3){bar3 += 1}
  else if(studentStats[i]["Final Points"] <= increment4){bar4 += 1}
  else if(studentStats[i]["Final Points"] <= increment5){bar5 += 1}
  else {bar6 += 1}
}

const ctx = document.getElementById('classPointsChart').getContext('2d');
const classPointsChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['<=' + increment1,'<=' + increment2,'<=' + increment3,'<=' + increment4,'<=' + increment5,'<=' + mixClassStats["max_points"]],
        datasets: [{
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
            max: mixClassStats["Student count"],
            title: {
              display: true,
              text: 'Students'
            }
          },
          x: {
            ticks: {
              minRotation: 0,
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
var bar6 = 0

var increment1 = 100 / 6
increment1 = Math.round(increment1 * 100) / 100
var increment2 = increment1 + 100 / 6
increment2 = Math.round(increment2 * 100) / 100
var increment3 = increment2 + 100 / 6
increment3 = Math.round(increment3 * 100) / 100
var increment4 = increment3 + 100 / 6
increment4 = Math.round(increment4 * 100) / 100
var increment5 = increment4 + 100 / 6
increment5 = Math.round(increment5 * 100) / 100
var increment6 = increment5 + 100 / 6
increment6 = Math.round(increment6 * 100) / 100

for (i = 0; i < Object.keys(studentStats).length; i++) {
  if(studentStats[i]["Current Score"] <= increment1){bar1 += 1}
  else if(studentStats[i]["Current Score"] <= increment2){bar2 += 1}
  else if(studentStats[i]["Current Score"] <= increment3){bar3 += 1}
  else if(studentStats[i]["Current Score"] <= increment4){bar4 += 1}
  else if(studentStats[i]["Current Score"] <= increment5){bar5 += 1}
  else {bar6 += 1}
}

const ctx2 = document.getElementById('classScoresChart').getContext('2d');
const classScoresChart = new Chart(ctx2, {
    type: 'bar',
    data: {
        labels: ['<=' + increment1,'<=' + increment2,'<=' + increment3,'<=' + increment4,'<=' + increment5,'<=' + 100],
        datasets: [{
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
          text: 'Current class score (%)'
        }
      },
      scales: {
          y: {
            max: mixClassStats["Student count"],
            title: {
              display: true,
              text: 'Students'
            }
          },
          x: {
            ticks: {
              minRotation: 0,
            }
          }
      }
    }
});
</script>
@endsection
