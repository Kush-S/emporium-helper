@extends('layouts.app')

@section('content')
<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>

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
        <span class="">{{$studentData['first_name']}} {{$studentData['last_name']}}</span>
      </div>
      <div class="text-center h4">
        <span class="text-decoration-underline">Email:</span>
        <span class="">{{$studentData['primary_email']}}</span>
      </div>
      <div class="text-center h4">
        <span class="text-decoration-underline">zyBooks file selected:</span>
        <span class="">{{$selected_zybooks_file}}</span>
      </div>
      <div class="text-center h4">
        <span class="text-decoration-underline">Current risk:</span>
        <span class="{{ $studentData['risk'] > 30 ? 'text-danger' : 'text-success' }}">{{$studentData['risk']}}%</span>
      </div>
      {{-- <div class="text-center h4">
        <span class="text-decoration-underline">Notified:</span>
        <span class="">No</span>
      </div> --}}
    </div>
    <div class="col m-auto">
      <div class="pt-2 text-center">
        <div class="my-1">
          Send {{$studentData['first_name']}} an email notification
        </div>
        <div class="mb-1">
          <form method="POST" enctype="multipart/form-data" action="{{ route('analysis_email_student', Request()->id) }}">
            @csrf
            <input type="hidden" name="studentName" value="{{$studentData['first_name']}}">
            <input type="hidden" name="classNumber" value="{{$classroom->number}}">
            <input type="hidden" name="studentEmail" value="{{$studentData['primary_email']}}">
            <button type="submit" class="btn btn-danger">Notify</button>
          </form>
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
        labels: ['Participation' + ' ' + '({{$studentData['participation_total']}})',
                'Challenge' + ' ' + '({{$studentData['challenge_total']}})',
                'Lab' + ' ' + '({{$studentData['lab_total']}})'],
        datasets: [{
            data: [{{$studentData['participation_total']}}, {{$studentData['challenge_total']}}, {{$studentData['lab_total']}}],
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
          text: 'Scores (%) for ' + '{{$studentData['first_name']}}' + ' {{$studentData['last_name']}}'
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
var zybooksClassStats = {!! json_encode($zybooksClassStats) !!}
console.log(zybooksClassStats)

const ctx2 = document.getElementById('classBarChart').getContext('2d');
const classBarChart = new Chart(ctx2, {
    type: 'bar',
    data: {
        labels: ['Participation ' + zybooksClassStats['Participation average'], 'Challenge ' + zybooksClassStats['Challenge average'], 'Lab ' + zybooksClassStats['Lab average']],
        datasets: [{
            data: [zybooksClassStats['Participation average'], zybooksClassStats['Challenge average'], zybooksClassStats['Lab average']],
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
