@extends('layout.header')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h3 class="h3 mb-0 text-gray-800"><strong>PAGES - USERS</strong></h3>
    </div>
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
    <div class="card shadow mb-4">
        <div class="card-body">
            <a href="{{ url('users/create') }}" class="btn btn-outline-primary m-1">+ Tambah</a>
            <br><br>
            <div class="table-responsive">
                <table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>NAMA LENGKAP</th>
                            <th>USERNAME</th>
                            <th>ROLE</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->nama }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->role }}</td>
                            <td>
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-outline-warning m-1"><i class="ti ti-edit"></i></a>
                                <a href="{{ route('users.changepassword', $user->id )}}" class="btn btn-outline-success m-1"><i class="ti ti-key"></i></a>
                                <a href="{{ route('users.destroy', $user->id) }}"
                                    class="btn btn-outline-danger m-1r"
                                    onclick="event.preventDefault();
                                    if (confirm('Apakah anda yakin ingin menghapus?')) {
                                        document.getElementById('delete-form-{{ $user->id }}').submit();
                                    }">
                                    <i class="ti ti-trash"></i>
                                <form id="delete-form-{{ $user->id }}" action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: none;">
                                    @method('DELETE')
                                    @csrf
                                </form>
                                
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
