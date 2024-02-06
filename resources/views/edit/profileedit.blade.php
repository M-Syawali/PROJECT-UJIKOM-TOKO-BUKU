@extends('layout.header')
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h3 class="h3 mb-0 text-gray-800"><strong>PAGES - EDIT PROFILE</strong></h3>
</div>
<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body ">
                    <a href="{{ route('profile.index') }}" class="btn btn-outline-dark m-1"><i class="ti ti-arrow-left"></i></a>
                    <br><br>
                    <form method="POST" action="{{ route('profile.update', $users->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" id="username" class="form-control" name="username" value="{{ $users->username }}">
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" id="nama" class="form-control" name="nama" value="{{ $users->nama }}">
                        </div>
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select name="role" id="role" class="form-control">
                                <option value="">- Pilih Role -</option>
                                <option value="admin" {{ $users->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="kasir" {{ $users->role == 'kasir' ? 'selected' : '' }}>Kasir</option>
                                <option value="owner" {{ $users->role == 'owner' ? 'selected' : '' }}>Owner</option>
                            </select>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-outline-primary m-1">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
