@extends('layout.header')
@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><strong>PAGES - DATA PEMBELIAN</strong></h1>
    <!-- Content Row -->
    <div class="row">
<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Product</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $products }}
                    <small> Item</small></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Transactions</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $transactions }}
                        <small>Orang</small></div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-ticket fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Income</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">Rp.  {{ number_format($income, 0, ',', '.')  }}
                        <small></small></div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-money-bill fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Role</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $users }}
                        <small>Person</small></div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-users fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
 <!--  Header End -->
@endsection

