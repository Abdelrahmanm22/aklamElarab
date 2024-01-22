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
                    {{-- <h1 class="m-0">Dashboard</h1> --}}
                    <a href="{{ route('advertisement.store') }}" class="btn btn-success">Add Advertisement</a>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Advertisement</li>
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
    @if (Session::has('error'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            {{ Session::get('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">DataTable For All Advertisement</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Advertisement Image</th>
                                <th>Admen Name</th>
                                <th>Created At</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($advertisement as $a)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <img src="{{URL::asset('Attachment/Advertisement/'.$a->img)}}" width="200"  alt="book image">
                                    </td>
                                    <td>{{ $a->admin->name }}</td>
                                    <td>{{ $a->created_at }}</td>
                                    <td>
                                        <a class="btn btn-danger delete-advertisement" data-toggle="modal"
                                            data-target="#deleteAdvertisementModal"
                                            data-advertisement-id="{{ $a->id }}">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Publisher Name</th>
                                <th>Admen Name</th>
                                <th>Created At</th>
                                <th>Delete</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>

            <!-- Delete Category Modal -->
            <div class="modal fade" id="deleteAdvertisementModal" tabindex="-1" role="dialog"
                aria-labelledby="deleteAdvertisementModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteAdvertisementModalLabel">Delete Advertisement</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="deleteAdvertisementForm" method="POST" action="{{ url('dashboard/advertisement/delete/') }}">
                            @csrf
                            @method('POST')
                            <div class="modal-body">
                                <p>Are you sure you want to delete this Advertisement?</p>
                                
                                <input type="hidden" name="advertisement_id" id="deleteAdvertisementId" value="">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
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

            // Handle delete button click
            $('.delete-advertisement').on('click', function() {
                // Get the publisher ID from the data attribute
                var advertisementId = $(this).data('advertisement-id');

                // Set the publisher ID in the form
                $('#deleteAdvertisementId').val(advertisementId);

                // Show the modal
                $('#deleteAdvertisementIdModal').modal('show');
            });
            // setting for table
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": true,
                //"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>

@endsection
