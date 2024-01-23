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
                    <a href="{{ route('book.store') }}" class="btn btn-success">Add Book</a>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Book</li>
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
                    <h3 class="card-title">DataTable For All Books</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Book Image</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Rate</th>
                                <th>Views</th>
                                <th>Publisher</th>
                                <th>Admin Name</th>
                                <th>Created At</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($book as $b)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <img src="{{ URL::asset('Attachment/Books/Images/' .$b->author_id.'/'. $b->image) }}" width="200"
                                            alt="book image">
                                    </td>
                                    <td>{{ $b->name }}</td>
                                    <td>{{ $b->description }}</td>
                                    <td>{{ $b->rate }}</td>
                                    <td>
                                        @php
                                            if ($b->view < 1000) {
                                                echo $b->view;
                                            } elseif ($b->view < 1000000) {
                                                echo round($b->view / 1000, 1) . 'K';
                                            } else {
                                                echo round($b->view / 1000000, 1) . 'M';
                                            }
                                        @endphp
                                    </td>
                                    <td>{{ $b->publisher->name }}</td>
                                    <td>{{ $b->admin->name }}</td>
                                    <td>{{ $b->created_at }}</td>
                                    <td>
                                        <a class="btn btn-danger delete-book" data-toggle="modal"
                                            data-target="#deleteBookModal"
                                            data-book-id="{{ $b->id }}">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Book Image</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Rate</th>
                                <th>Views</th>
                                <th>Publisher</th>
                                <th>Admin Name</th>
                                <th>Created At</th>
                                <th>Delete</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>

            <!-- Delete Category Modal -->
            <div class="modal fade" id="deleteBookModal" tabindex="-1" role="dialog"
                aria-labelledby="deleteBookModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteBookModalLabel">Delete Book</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="deleteBookForm" method="POST"
                            action="{{ url('dashboard/book/delete/') }}">
                            @csrf
                            @method('POST')
                            <div class="modal-body">
                                <p>Are you sure you want to delete this Book?</p>

                                <input type="hidden" name="book_id" id="deleteBookId" value="">
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
            $('.delete-book').on('click', function() {
                // Get the publisher ID from the data attribute
                var bookId = $(this).data('book-id');

                // Set the publisher ID in the form
                $('#deleteBookId').val(bookId);

                // Show the modal
                $('#deleteBookIdModal').modal('show');
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
