@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="card">
                <div class="card-header">
                  <div class="float-start">Classes</div>
                  <a href="#" class="float-end">Search <i class="bi bi-search fas fa-2x"></i></a>
                </div>
                <div class="container">
                  <div class="row">
                    <form>
                      <div class="mb-3">
                        <label class="form-label">Term</label>
                        <select name="term" class="form-select">
                          <option {{$searchdata['term'] == '' ? "selected" : ""}}></option>
                          <option {{$searchdata['term'] == 'Spring' ? "selected" : ""}}>Spring</option>
                          <option {{$searchdata['term'] == 'Summer' ? "selected" : ""}}>Summer</option>
                          <option {{$searchdata['term'] == 'Fall' ? "selected" : ""}}>Fall</option>
                        </select>
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Year</label>
                        <input class="form-control" name="year" value="{{$searchdata['year'] ?? ""}}">
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Course Number</label>
                        <input class="form-control" name="number" value="{{$searchdata['number'] ?? ""}}">
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Section</label>
                        <input class="form-control" name="section" value="{{$searchdata['section'] ?? ""}}">
                      </div>
                      <button type="submit" class="btn btn-primary">Search</button>
                    </form>
                  </div>
                </div>
                <div class="card-body">
                  <table class="table table-striped table-hover">
                    <thead>
                      <tr>
                        <th scope="col">Term</th>
                        <th scope="col">Year</th>
                        <th scope="col">Number</th>
                        <th scope="col">Section</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($classrooms as $classroom)
                          <tr>
                            <td>{{ $classroom->term }}</td>
                            <td>{{ $classroom->year }}</td>
                            <td>{{ $classroom->number }}</td>
                            <td>{{ $classroom->section }}</td>
                            <td><a href="{{ route("classroom_enter", $classroom->id) }}">Visit</a></td>
                          </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
