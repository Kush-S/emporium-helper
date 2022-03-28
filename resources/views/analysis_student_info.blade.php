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
        <span class=""> Joe Doe 2</span>
      </div>
      <div class="text-center h4">
        <?php $randRisk =  rand(0,10) ?>
        <span class="text-decoration-underline">Current risk:</span>
        <span class="{{ $randRisk > 0 ? 'text-danger' : '' }}">{{$randRisk}}%</span>
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
          <div class="pt-2 text-center">
            <a href="{{ route('analysis_students_list', Request()->id) }}" class="btn btn-danger">Back to student list</a>
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
var nums = [5,2,1,4,5,6]
console.log(nums)
</script>
<script>
const ctx = document.getElementById('gradesBarChart').getContext('2d');
const gradesBarChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Participation', 'Challenge', 'Lab'],
        datasets: [{
            label: 'Students at risk',
            data: [50,90,70],
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
