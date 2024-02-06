@extends('layout.header')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h3 class="h3 mb-0 text-gray-800"><strong>PAGES - LOG ACTIVITY</strong></h3>
    </div>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>NAMA LENGKAP</th>
                            <th>ACTIVITY</th>
                            <th>TANGGAL</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($logM as $l)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $l->nama }}</td>
                            <td>{{ $l->activity }}</td>
                            <td>{{ $l->created_at }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
