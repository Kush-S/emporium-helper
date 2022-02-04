@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 offset-md-1">
      <div class="card">
        <div class="card-header">Create a new Classroom</div>
        <div class="card-body justify-content-center">
          <div class="">
            <form method="POST" enctype="multipart/form-data" action="{{ route('classroom_save') }}">
              @csrf
              <div class="form-group col-md-4">
                <div class="form-group pb-3">
                  <label for="inputState">Class Term</label>
                  <select name="class_term" class="form-select" required>
                    <option selected>Spring</option>
                    <option>Summer</option>
                    <option>Fall</option>
                  </select>
                </div>
                <div class="form-group pb-3">
                  <label for="file_name">Class Year</label>
                  <input type="number" class="form-control" name="class_year" placeholder="Example: 2022" required></input>
                </div>
                <div class="form-group pb-3">
                  <label for="file_name">Class Number</label>
                  <input type="text" class="form-control" name="class_number" placeholder="Example: CS 2010" required></input>
                </div>
                <div class="form-group pb-3">
                  <label for="file_name">Class Section</label>
                  <input type="text" class="form-control" name="class_section" placeholder="Example: 1 1003 LEC 13187 GC" required></input>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
