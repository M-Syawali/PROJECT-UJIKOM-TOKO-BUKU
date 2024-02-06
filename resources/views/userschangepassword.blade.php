@extends('layout.header')
@section('content')
<h3 class="h3 mb-0 text-gray-800"><strong>PAGES - GANTI PASSWORD</strong></h3>
<section class="section">
    <div class="section-header">
        <br>
    </div>
        <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-body ">
                  <a href="{{ route('users.index') }}" 
                  class="btn btn-outline-dark m-1"><i class="ti ti-arrow-left"></i></a>
                  <br><br>
                    <form action="{{ route('users.change', $users->id )}}" method="POST">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" id="username" class="form-control" name="username"  placeholder="..." value="{{ $users->username}}" readonly>
                            @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password_new">Password Baru</label>
                            <input type="password" id="password_new" class="form-control" name="password_new"  placeholder="Masukan password baru">
                            @error('password_new')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password_confirm">Confirm Password</label>
                            <input type="password" id="password_confirm" class="form-control" name="password_confirm"  placeholder="Konfirmasi password baru">
                            @error('password_confirm')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <br>
                    <button type="submit" class="btn btn-outline-primary m-1">Submit</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </div>
</section>
@endsection