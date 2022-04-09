@extends('layouts.app')

@section('content')
<div class="container pb-4">
    <div class="row">
      <div class="col-md-10 offset-md-1">
        <div class="card">
          <div class="card-header">Credits</div>
          <div class="card-body">
            <div class="row justify-content-center pb-2">
              zyCat was made by Kshitij (Kush) Saxena during Spring 2022, and presented during the poster presentation on April 15, 2022.
            </div>

            <div class="row justify-content-center mt-4">
              This advisor for this project was Dr. Chao.
            </div>

            <div class="row justify-content-center mt-4">
              The photos on the classroom create page were taken by Dr. Chao.
            </div>

            <div class="row justify-content-center mt-4">
              The app logo was created using: https://express.adobe.com/express-apps/logomaker/
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
