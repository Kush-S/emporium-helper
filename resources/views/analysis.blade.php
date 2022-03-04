<x-headers/>

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
    <div class="col-md-6 text-center">

    </div>
    <div class="">
      <a href="{{ route('analysis_students', Request()->id) }}" class="btn btn-primary">Student list</a>
    </div>
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
        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
        datasets: [{
            label: '# of Votes',
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
            }
        }
    }
});
</script>

<script>
  const labels = [
    'January',
    'February',
    'March',
    'April',
    'May',
    'June',
  ];

  const data = {
    labels: labels,
    datasets: [{
      label: 'My First dataset',
      backgroundColor: 'rgb(255, 99, 132)',
      borderColor: 'rgb(255, 99, 132)',
      data: nums,
    }]
  };

  const config = {
    type: 'line',
    data: data,
    options: {}
  };
</script>
<script>
  const myChart2 = new Chart(
    document.getElementById('chart2'),
    config
  );
</script>
