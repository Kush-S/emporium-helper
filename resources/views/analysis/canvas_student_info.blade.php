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
        <span class="text-decoration-underline">Canvas file selected:</span>
        <span class="">{{$selected_canvas_file}}</span>
      </div>
      <div class="text-center h4">
        <span class="text-decoration-underline">Current risk:</span>
        <span class="{{ $studentData['risk'] > 30 ? 'text-danger' : 'text-success' }}">{{$studentData['risk']}}%</span>
      </div>
      <div class="text-center h4">
        <span class="text-decoration-underline">Notified:</span>
        <span class="">No</span>
      </div>
    </div>
    <div class="col m-auto">
      <div class="pt-2 text-center">
        <div class="my-1">
          Send {{$studentData['student_name']}} an email notification
        </div>
        <div class="mb-1">
          <a href="{{ route('analysis_zybooks_students_list', Request()->id) }}" class="btn btn-danger">Notify</a>
        </div>
        <label for="exampleInputEmail1" class="form-label">*email template can be set in settings</label>
      </div>
    </div>

  </div>
  <div class="row pt-4">
    <div class="col-6 text-center p-4 border">
      <canvas id="studentBarChart"></canvas>
    </div>
    <div class="col-6 text-center p-4 border">
      <canvas id="classBarChart"></canvas>
    </div>
  </div>
</div>
<x-footer/>

<script>
const ctx = document.getElementById('studentBarChart').getContext('2d');
const studentBarChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['1', '2', '2'],
        datasets: [{
            data: [10,20,30],
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
          text: 'Scores (%) for ' + '' + ' '
        }
      },
      scales: {
          y: {
              beginAtZero: true,
              min: 0,
              max: 100
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
var zybooksClassStats = ''
console.log(zybooksClassStats)

const ctx2 = document.getElementById('classBarChart').getContext('2d');
const classBarChart = new Chart(ctx2, {
    type: 'bar',
    data: {
        labels: ['1','2','3'],
        datasets: [{
            data: [10,20,30],
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
          text: 'Class average scores (%)'
        }
      },
      scales: {
          y: {
              beginAtZero: true,
              min: 0,
              max: 100
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
