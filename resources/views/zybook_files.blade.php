<x-headers/>

<div class="container mx-auto h-screen bg-gray-50 p-5">
  <div class="pb-1 mx-auto">
    Upload zyBooks files here. One file for each week.
  </div>
  <div class="box-border mx-auto h-32 w-64 border-4 p-2">
    @for ($i = 1; $i <= 15; $i++)
      <label>Week {{$i}}</label>
    @endfor
    {{-- File download here --}}
  </div>
  <div>
    <form method="POST" enctype="multipart/form-data" action="{{ route('uploadFile') }}">
      @csrf
      <label>Select Week</label>
      <select name="file_name">
        @for ($i = 1; $i <= 15; $i++)
          <option value="week{{$i}}">Week {{$i}}</option>
        @endfor
      </select>
      <input type="submit">
    </form>
  </div>
</div>
