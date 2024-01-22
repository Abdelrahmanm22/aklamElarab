@extends('layouts.master')
@section('title')
    {{ $title }}
@stop

@section('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ URL::asset('back/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('back/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('back/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

@section('page-header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <a href="{{ route('author.store') }}" class="btn btn-success">Add Author</a>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Authors</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
@endsection

@section('content')
    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible" role="alert">
            {{ Session::get('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">DataTable For All Authors</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Author Name</th>
                                <th>Gender</th>
                                <th>Phone</th>
                                <th>Percentage of views</th>
                                <th>Number of Books</th>
                                <th>Added At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($authors as $a)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $a->name }}</td>
                                    <td>{{ $a->gender }}</td>
                                    <td>{{ $a->phone }}</td>
                                    <td>
                                        @php
                                            $totalViews = $totalViews ?: 1; // Ensure that $totalViews is not zero to avoid division by zero
                                            $percentage = ($a->books()->sum('view') / $totalViews) * 100;
                                            echo round($percentage, 2) . '%';
                                        @endphp
                                    </td>
                                    <td>{{ $a->books()->count() }}</td>
                                    <td>{{ $a->created_at }}</td>
                                    {{-- <td>
                                        <a class="btn btn-danger delete-advertisement" data-toggle="modal"
                                            data-target="#deleteAdvertisementModal"
                                            data-advertisement-id="{{ $a->id }}">Delete</a>
                                    </td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Author Name</th>
                                <th>Gender</th>
                                <th>Phone</th>
                                <th>Percentage of views</th>
                                <th>Number of Books</th>
                                <th>Added At</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div><!-- /.container-fluid -->
    </section>
@endsection


@section('scripts')
    <!-- DataTables  & Plugins -->
    <script src="{{ URL::asset('back/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('back/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('back/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('back/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('back/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('back/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('back/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('back/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('back/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('back/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('back/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('back/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

    <script>
        $(function() {
            // setting for table
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": true,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>

@endsection
