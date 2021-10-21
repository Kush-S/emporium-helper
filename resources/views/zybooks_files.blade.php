<x-headers/>

<div class="container bg-light">
  <div class="w-max p-5 mx-auto text-lg">
    <h>Upload zyBooks files here. One file for each week.</p>
  </div>
  <div class="box-border mx-auto h-32 w-64 border-4 p-2">
    @foreach ($files as $file)
      <a href="{{route('files_download', $file->name)}}">{{$file->name}}</a>
      <a href="{{route('files_delete', $file->name)}}" type="button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded cursor-pointer">Delete</a>
    @endforeach
  </div>
  <div class="py-5">
    <form method="POST" enctype="multipart/form-data" action="{{ route('files_upload') }}">
      @csrf
      <label for="file_name">File Name: </label>
      <input type="text" name="file_name" placeholder="Example: zyBooks week 1" required></input>
      <input type="file" name="zybooks_file_input" required>
      <input type="submit">
    </form>
  </div>
</div>
