@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="card">
                <div class="card-header">Classes</div>

                <div class="card-body">
                  @foreach ($classrooms as $classroom)
                    <p>This is the class {{ $classroom }}</p>
                  @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
