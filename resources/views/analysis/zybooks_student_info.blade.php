@extends('layouts.app')

@section('content')
<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>

<div class="container bg-light border rounded mt-4 mb-5">
  <div class="row">
    <div class="col-5 my-auto">
      <div class="text-center h4">
        <span class="text-decoration-underline">Class:</span>
        <span class=""> CS 2010, Sp' 20</span>
      </div>
      <div class="text-center h4">
        <span class="text-decoration-underline">Name:</span>
        <span class="">{{$studentData['first_name']}} {{$studentData['last_name']}}</span>
      </div>
      <div class="text-center h4">
        <span class="text-decoration-underline">Current risk:</span>
        <span class="{{ $studentData['risk'] > 30 ? 'text-danger' : 'text-success' }}">{{$studentData['risk']}}%</span>
      </div>
      <div class="text-center h4">
        <span class="text-decoration-underline">Notified:</span>
        <span class="">No</span>
      </div>

      <div class="row mx-auto">
        <div class="col">
          <div class="pt-2 text-center">
            <a href="{{ route('analysis_students_list', Request()->id) }}" class="btn btn-primary">Notify</a>
          </div>
        </div>
      </div>
    </div>
    
    <div class="col-7 text-center p-4 border">
      <canvas id="gradesBarChart"></canvas>
    </div>
  </div>
</div>
<x-footer/>

<script>
const ctx = document.getElementById('gradesBarChart').getContext('2d');
const gradesBarChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Participation' + ' ' + '({{$studentData['participation_total']}})',
                'Challenge' + ' ' + '({{$studentData['challenge_total']}})',
                'Lab' + ' ' + '({{$studentData['lab_total']}})'],
        datasets: [{
            label: 'Students at risk',
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
          text: 'Scores (%)'
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
