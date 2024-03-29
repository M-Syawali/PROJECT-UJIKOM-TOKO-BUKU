<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pembelian Buku</title>
  <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/navbar.png') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
</head>

<body>

  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div class="position-relative overflow-hidden bg-light min-vh-100 d-flex align-items-center justify-content-center">
      <div class="container"> <!-- Tambahkan kelas 'container' di sini -->
        <div class="row justify-content-center"> <!-- Mengubah 'justify-content-center' menjadi 'justify-content-end' -->
          <div class="col-md-8 col-lg-5 col-xxl-3">
            <div class="card mb-0">
              <div class="card-body">
                <a href="./index.html" class="text-nowrap logo-img text-center d-block py-3 w-100">
                  <img src="{{ asset('assets/images/loginbook.png') }}" width="180" alt="">
                </a>
                <p class="text-center">Toko Pembelian Buku</p>
                <form action="{{ route('login.action')}}" method="post" >
                @csrf
                @if(session('error'))
                  <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                  </div>
                @endif
                <div class="form-group">
                <label for="exampleInputEmail1" class="form-label">Username</label>
                        <input type="text" class="form-control form-control-user"
                        id="exampleInputusername" aria-describedby="username"
                        placeholder="Username" name="username">   
                    </div>
                    <br>
                    <div class="form-group">
                    <label for="exampleInputEmail1" class="form-label">Password</label>
                        <input type="password" class="form-control form-control-user"
                        id="exampleInputpassword" placeholder="Password" name="password">
                    </div>
                    <br>
                    <br>
                <button type="submit" class="btn btn-outline-primary m-1 w-100 py-8 fs-4 mb-4 rounded-2">Login</button>
            </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>