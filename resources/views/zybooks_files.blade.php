<x-headers/>

<div class="container mx-auto h-screen bg-gray-50 p-5">
  <div class="w-max p-5 mx-auto text-lg">
    <h>Upload zyBooks files here. One file for each week.</p>
  </div>
  <div class="box-border mx-auto h-32 w-64 border-4 p-2">
    @foreach ($files as $file)
      <a href="{{route('files_download', $file->name)}}">{{$file->name}}</a>
    @endforeach
  </div>
  <div>
    <form method="POST" enctype="multipart/form-data" action="{{ route('files_upload') }}">
      @csrf
      <label for="file_name">File Name: </label>
      <input type="text" name="file_name" placeholder="Example: zyBooks week 1" required></input>
      <input type="file" name="zybooks_file" required>
      <input type="submit">
    </form>
  </div>
</div>
