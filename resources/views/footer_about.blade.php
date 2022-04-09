@extends('layouts.app')

@section('content')
<div class="container pb-4">
    <div class="row">
      <div class="col-md-10 offset-md-1">
        <div class="card">
          <div class="card-header">About</div>
          <div class="card-body">
            <div class="row justify-content-center pb-2">
              zyCat is an application design to help Computer Science instructors at BGSU determine if a student is at risk of failing the class.
            </div>

            <div class="row justify-content-center mt-4">
              Early Computer Science courses form a foundation from which all future CS classes build from. Without a strong foundation built during the early classes, a student is likely to have problems in future CS classes, and might not be able to finish the degree.
            </div>

            <div class="row justify-content-center mt-4">
              zyCat works by analysing zyBooks and Canvas grade files which are provided by the instructor, and shows the risk of every student in the class.
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
