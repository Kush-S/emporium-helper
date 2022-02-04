@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="card">
                <div class="card-header">Classes</div>

                <div class="card-body">
                  <table class="table table-striped table-hover">
                    <thead>

                    </thead>
                  </table>

                  @foreach ($classrooms as $classroom)
                    <p>List of classes: {{ $classroom }}</p>
                  @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
