
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>TB | {{ $subtitle }}</title>
  <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/navbar.png') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" class="rell">
  <!-- Include SweetAlert2 styles -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">

  <style>
    .card-body {
    overflow-x: auto;
    }
  </style>
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
    <aside class="left-sidebar">
      <!-- Sidebar scroll-->
      <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
          <a href="./index.html" class="text-nowrap logo-img">
            <img src="{{ asset('assets/images/book.png') }}" width="180" alt="" />
          </a>
          <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
            <i class="ti ti-x fs-8"></i>
          </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
          <ul id="sidebarnav">
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">Home</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{ url('dashboard')}}" aria-expanded="false">
                <span>
                  <i class="ti ti-home"></i>
                </span>
                <span class="hide-menu">Dashboard</span>
              </a>
            </li>
            @if (Auth::user()->role== 'admin')
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">Products</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{ url('products')}}" aria-expanded="false">
                <span>
                  <i class="ti ti-book"></i>
                </span>
                <span class="hide-menu">Buku</span>
              </a>
            </li>
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">Transactions</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{ url('transactions')}}" aria-expanded="false">
                <span>
                <i class="menu-icon ti ti-shopping-cart"></i>
                </span>
                <span class="hide-menu">Transactions</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{ url('datapembelian')}}" aria-expanded="false">
                <span>
                  <i class="ti ti-database"></i>
                </span>
                <span class="hide-menu">Data Pembelian</span>
              </a>
            </li>
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">Auth</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{ url('users')}}" aria-expanded="false">
                <span>
                  <i class="ti ti-users"></i>
                </span>
                <span class="hide-menu">Users</span>
              </a>
            </li>
            @endif
            @if (Auth::user()->role== 'kasir')
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">Transactions</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{ url('transactions')}}" aria-expanded="false">
                <span>
                <i class="menu-icon ti ti-shopping-cart"></i>
                </span>
                <span class="hide-menu">Transactions</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{ url('datapembelian')}}" aria-expanded="false">
                <span>
                  <i class="ti ti-database"></i>
                </span>
                <span class="hide-menu">Data Pembelian</span>
              </a>
            </li>
            @endif
            @if (Auth::user()->role== 'owner')
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">Products</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{ url('products')}}" aria-expanded="false">
                <span>
                  <i class="ti ti-book"></i>
                </span>
                <span class="hide-menu">Buku</span>
              </a>
            </li>
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">Transactions</span>
            </li>
         
              <li class="sidebar-item">
              <a class="sidebar-link" href="{{ url('datapembelian')}}" aria-expanded="false">
                <span>
                  <i class="ti ti-database"></i>
                </span>
                <span class="hide-menu">Data Pembelian</span>
              </a>
            </li>
              <li class="sidebar-item">
              <a class="sidebar-link" href="{{ url('laporan')}}" aria-expanded="false">
                <span>
                  <i class="ti ti-file"></i>
                </span>
                <span class="hide-menu">Laporan</span>
              </a>
            </li>
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">Auth</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{ url('log')}}" aria-expanded="false">
                <span>
                  <i class="ti ti-history"></i>
                </span>
                <span class="hide-menu">Log</span>
              </a>
              </li>
            @endif
           
          </ul>
        </nav>
        <!-- End Sidebar navigation -->
      </div>
      <!-- End Sidebar scroll-->
    </aside>
    <!--  Sidebar End -->
    <!--  Main wrapper -->
    <div class="body-wrapper">
      <!--  Header Start -->
      <header class="app-header">
        <nav class="navbar navbar-expand-lg navbar-light">
          <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
              <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                <i class="ti ti-menu-2"></i>
              </a>
            </li>
          </ul>
          <div class="navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav align-items-center">
            <li class="nav-item">
            <h6>Hi, {{ Auth::user()->nama }} - {{ Auth::user()->role }}</h6>
            </li>
            <li class="nav-item dropdown">
            <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                aria-expanded="false">
                <img src="{{ asset('assets/images/profile/user-1.jpg') }}" alt="" width="35" height="35" class="rounded-circle">
            </a>
            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                <div class="message-body">
                <a href="{{ route('profile.index')}}" class="d-flex align-items-center gap-2 dropdown-item">
                    <i class="ti ti-user fs-6"></i>
                    <p class="mb-0 fs-3">My Profile</p>
                </a>
                <a href="{{ url('/logout')}}" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                </div>
            </div>
            </li>
        </ul>
        </div>

        </nav>
      </header>
      <!--  Header End -->
      <div class="container-fluid">
      @yield('content')
        <div class="py-6 px-6 text-center">
          <p class="mb-0 fs-4">Design and Developed by <a style="color: blue;">Muhamad W. Syawali</a></p>
        </div>
      </div>
    </div>
  </div>
  <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
  <script src="{{ asset('assets/js/app.min.js') }}"></script>
  <script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
  <script src="{{ asset('assets/libs/simplebar/dist/simplebar.js') }}"></script>
  <script src="{{ asset('assets/js/dashboard.js') }}"></script>
  
  <script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
 
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.min.js"></script>

  <!-- Include SweetAlert2 scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/3.3.2/js/dataTables.fixedColumns.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            let table = $('#myTable').DataTable({
                "paging": true,
                "searching": true,
                "ordering": true,
                
            });

            new $.fn.dataTable.FixedColumns(table, {
                leftColumns: 1, // Number of columns to be fixed on the left
                heightMatch: 'auto' // Auto adjust the height of the fixed columns
            });
        });
    </script>
</body>

</html>