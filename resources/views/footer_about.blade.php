@extends('layouts.app')

@section('content')
<div class="container pb-4">
    <div class="row">
      <div class="col-md-10 offset-md-1">
        <div class="card">
          <div class="card-header">About</div>
          <div class="card-body">
            <div class="row justify-content-center pb-2">
              This app is, and does...
            </div>

            <div class="row justify-content-center mt-4">
              For...
            </div>

            <div class="row justify-content-center mt-4">
              Why...
            </div>

            <div class="col-md-6 my-5 d-flex justify-content-center text-center m-auto">
              <img src="{{ asset('images/bgsu_logo2.jpg') }}" style="width:70%;">
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
<x-footer/>
@endsection
