<x-headers/>
<div class="container bg-light border rounded mb-5">
  <div class="p-5 d-flex justify-content-center">
      <h4>Upload zyBooks and Canvas grade files here</h4>
  </div>

  <div class="pt-2 d-flex justify-content-center">
    <form method="POST" enctype="multipart/form-data" action="{{ route('files_upload', Request()->id) }}">
      @csrf
      <div class="form-group pb-3">
        <input type="file" class="form-control-file" name="zybooks_file_input" required>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
        <label class="form-check-label" for="exampleRadios1">
          zyBooks file
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
        <label class="form-check-label" for="exampleRadios2">
          Canvas grade file
        </label>
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
