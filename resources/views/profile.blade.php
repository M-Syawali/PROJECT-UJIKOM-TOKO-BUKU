@extends('layout.header')
@section('content')
<h1 class="h3 mb-4 text-gray-800"><strong>PAGES - PROFILE</strong></h1>
<div class="row mt-10">
    <div class="col-lg-12">
        <div class="card profile-card-5">
           
                <div class="d-flex m-12">
                        <div class="card-body border-top border-light">
                        <a href="{{ route('dashboard.index') }}" 
                            class="btn btn-outline-dark m-1"><i class="ti ti-arrow-left"></i></a>     
                                <br>
                                @if ($message = Session::get('success'))
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function () {
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Success Message',
                                                text: @json($message),
                                                confirmButtonText: 'OK'
                                            });
                                        });
                                    </script>
                                @endif
                                <form>
                                    <div class="form-group row">
                                        <label class="col-lg-12 col-form-label form-control-label">Nama Lengkap</label>
                                        <div class="col-lg-12">
                                            <input class="form-control" type="text" value="{{ Auth::user()->nama}}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-12 col-form-label form-control-label">Username</label>
                                        <div class="col-lg-12">
                                            <input class="form-control" type="text" value="{{ Auth::user()->username}}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-12 col-form-label form-control-label">Role</label>
                                        <div class="col-lg-12">
                                            <input class="form-control" type="text" value="{{ Auth::user()->role}}" readonly>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="d-flex">
                                    <a href="{{ route('profile.edit', Auth::user()->id) }}" class="btn btn-outline-info m-1"><i class="ti ti-edit"></i></a>

                                </div>
                                </form>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
@endsection
