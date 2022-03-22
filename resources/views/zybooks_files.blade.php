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
  <div class="p-5 d-flex justify-content-center">
      <h4>Upload zyBooks and Canvas grade files here</h4>
  </div>

  <div class="pt-2 d-flex justify-content-center">
    <form method="POST" enctype="multipart/form-data" action="{{ route('files_upload', Request()->id) }}">
      @csrf
      <div class="form-group pb-3">
        <input type="file" class="form-control-file" name="input_file" required>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="type" value="zybooks" checked>
        <label class="form-check-label" for="exampleRadios1">zyBooks file</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="type" value="canvas">
        <label class="form-check-label" for="exampleRadios2">Canvas grade file</label>
      </div>
      <button type="submit" class="btn btn-primary mt-2">Upload</button>
    </form>
  </div>

  {{-- <div class="py-5">
    @foreach ($files->chunk(5) as $chunk)
      <div class="d-flex justify-content-center">
          @foreach ($chunk as $file)
            <div class="p-2">
              <a class="p-1 border" href="{{route('files_download', $file->name, Request()->id)}}">{{$file->name}}</a>
              <a href="{{route('files_delete', $file->name)}}" type="button" class="btn btn-danger">Delete</a>
            </div>
          @endforeach
        </div>
    @endforeach
  </div> --}}
  <div class="pt-5 d-flex justify-content-center">
    zyBooks files | Canvas files
  </div>
</div>
<x-footer/>
