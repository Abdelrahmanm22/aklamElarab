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
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    {{-- <h1 class="m-0">Dashboard</h1> --}}
                    <a href="{{ route('publisher.store') }}" class="btn btn-success">Add Publisher</a>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Publisher</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">DataTable For All Publishers</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Publisher Name</th>
                                <th>Created At</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($publisher as $p)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        {{ $p->name }}
                                    </td>
                                    <td>{{ $p->created_at }}</td>
                                    <td>
                                        <a class="btn btn-danger delete-publisher" data-toggle="modal"
                                            data-target="#deletePublisherModal"
                                            data-publisher-id="{{ $p->id }}">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Publisher Name</th>
                                <th>Created At</th>
                                <th>Delete</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- Delete Publisher Modal -->
            <div class="modal fade" id="deletePublisherModal" tabindex="-1" role="dialog"
                aria-labelledby="deletePublisherModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deletePublisherModalLabel">Delete Publisher</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="deletePublisherForm" method="POST" action="{{ url('dashboard/publisher/delete/') }}">
                            @csrf
                            @method('POST')
                            <div class="modal-body">
                                <p>Are you sure you want to delete this publisher?</p>
                                <p>ملاحظه: سيؤدي حذف دار النشر الي حذف كل الكتب التابعه له</p>
                                <input type="hidden" name="publisher_id" id="deletePublisherId" value="">
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
            $('.delete-publisher').on('click', function() {
                // Get the publisher ID from the data attribute
                var publisherId = $(this).data('publisher-id');

                // Set the publisher ID in the form
                $('#deletePublisherId').val(publisherId);

                // Show the modal
                $('#deletePublisherModal').modal('show');
            });
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
