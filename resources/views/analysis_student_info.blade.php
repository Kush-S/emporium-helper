@extends('layouts.app')

@section('content')
<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
<div class="container">
  <div class="pb-2">
    <a href="{{ route('analysis_students_list', Request()->id) }}" class="btn btn-primary">Back to student list</a>
  </div>
</div>

<div class="container bg-light border rounded mb-5">
  <div class="row">
    <div class="col-md-6 text-center p-4 border">
      <canvas id="chart1"></canvas>
    </div>
    <div class="col-md-6 text-center p-4 border">
      <canvas id="chart2"></canvas>
    </div>
  </div>
  {{-- <div class="row" style="height: 300px"> --}}
  <div class="row">
    <div class="col-6 d-flex justify-content-center py-2">
      <div class="row pt-2">
        <div class="text-center">
          {{-- Files used: {{ count($randNums) }} --}}
        </div>
        <div class="text-center">
          <?php $randRisk =  rand(0,10) ?>
          Current risk: <span class="{{ $randRisk > 0 ? 'text-danger' : '' }}">{{$randRisk}}%</span>
        </div>
        <div class="text-center">
          Notified: No
        </div>
      </div>

    </div>
  </div>
</div>
<x-footer/>

<script>
var nums = [5,2,1,4,5,6]
console.log(nums)
</script>
<script>
const ctx = document.getElementById('chart1').getContext('2d');
const myChart1 = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Chapter 1.csv', 'Chapter 2.csv', 'Chapter 3.csv', 'Chapter 4.csv', 'Chapter 5.csv', 'Chapter 6.csv'],
        datasets: [{
            label: 'Students at risk',
            data: nums,
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
@endsection
