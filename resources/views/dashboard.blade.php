@extends('layout.header')
@section('content')
    <!-- Page Heading -->
    <br>
    <div class="card mt-3">
        <div class="card-content">
            <div class="row row-group m-0">
                <div class="col-12 col-lg-12 col-xl-12 border-light">
                    <div class="marquee-container"> <!-- Set the background color here -->
                        <br>
                        <marquee behavior="scroll" direction="right">
                            <h4 style="color : red;"><strong>Selamat Datang {{ Auth::user()->nama }} Di website Book Store</strong> - <strong> Anda login sebagai {{ Auth::user()->role}}</strong></h4>
                        </marquee>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-end m-8">
        <button type="submit" class="btn btn-light ml-auto"><i class="fa fa-calendar"></i> Today : {{ $todayDetails['dayName'] }}, {{ $todayDate }}</button>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="rounded overflow-hidden">
                <img class="img-profile" src="assets/images/dashboard1.jpeg" width="522px" height="300px">
            </div>
        </div>
        <div class="col-md-6">
            <div class="rounded overflow-hidden">
                <img class="img-profile" src="assets/images/dashboard2.jpeg" width="522px" height="300px">
            </div>
        </div>
    </div>
    <!-- Content Row -->
    <div class="row">
        <!-- Earnings (Monthly) Card Example -->


  
@endsection
