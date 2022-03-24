<x-headers/>

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

<div class="container d-flex justify-content-center ">
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
</div>

<div class="container bg-light border rounded mb-5">
  <div class="row">
    <div class="col-md-6 text-center p-4 border">
      <canvas id="chart2"></canvas>
    </div>
    <div class="col-6 d-flex justify-content-center">
      <div class="col py-5">
        <div class="text-center">
          <form method="POST" class="row p-2" action="#">
            @csrf
            <select class="form-select col" name="selected_file">
              @if ($selected_file == "")
                <option disabled selected>No file selected</option>
              @endif
              <option disabled>--zyBooks files--</option>
              @foreach ($zybooks_files as $file)
                <option value="{{ $file->name }}" id="{{ $file->type }}">{{ $file->name }}</option>
              @endforeach
              <option disabled>--Canvas files--</option>
              @foreach ($canvas_files as $file)
                <option value="{{ $file->name }}" id="{{ $file->type }}">{{ $file->name }}</option>
              @endforeach
            </select>
            <button type="submit" class="btn btn-primary col-2">Select</button>
          </form>
        </div>
        <div class="row pt-2">
          <div class="text-center">
            File selected: {{$selected_file}}
          </div>
          <div class="text-center">
            Files used: {{ count($randNums) }}
          </div>
          <div class="text-center">
            Total students: {{ rand(10,30) }}
          </div>
          <div class="text-center">
            <?php $randRisk =  rand(0,1) ?>
            Students at risk: <span class="{{ $randRisk > 0 ? 'text-danger' : '' }}">{{$randRisk}}</span>
          </div>
        </div>
        <a href="{{ route('analysis_students_list', Request()->id) }}" class="btn btn-primary d-flex justify-content-center p-3 col-4 mx-auto">Student list</a>
      </div>
    </div>

  </div>
  {{-- <div class="row" style="height: 300px"> --}}
  <div class="row">
    <div class="col-md-6 text-center p-4 border">
      <canvas id="chart1"></canvas>
    </div>
    <div class="col-6 d-flex justify-content-center py-2">


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
