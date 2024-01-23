@extends('layouts.master')
@section('title')
    {{ $title }}
@stop

@section('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ URL::asset('back/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('back/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

@section('page-header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    {{-- <h1 class="m-0">Dashboard</h1> --}}
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Add Book</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <!-- general form elements disabled -->
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Form To Add Book</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{ route('book.create') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-4">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>* Name of Book </label>
                                    <input type="text" name="name" class="form-control" value=""
                                        placeholder="Enter ...">
                                    @error('name')
                                        <small class="form-txt text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <!-- file input -->
                                <div class="form-group">
                                    <label>* Image of Book</label>
                                    <input type="file" name="image" class="form-control">
                                    @error('image')
                                        <small class="form-txt text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <!-- textarea -->
                                <div class="form-group">
                                    <label>* Description of Book</label>
                                    <textarea name="description" maxlength="2000" class="form-control" placeholder="Enter ..."></textarea>
                                    @error('description')
                                        <small class="form-txt text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- file input -->
                                <div class="form-group">
                                    <label>* PDF for Book</label>
                                    <input type="file" name="file" class="form-control">
                                    @error('file')
                                        <small class="form-txt text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <!-- file input -->
                                <div class="form-group">
                                    <label>* Trail for Book</label>
                                    <input type="file" name="trail" class="form-control">
                                    @error('trail')
                                        <small class="form-txt text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>* Select Publisher</label>
                                    <select name="publisher" class="form-control select2" style="width: 100%;">
                                        <option selected="selected">Open this to select Publisher</option>
                                        @foreach ($publishers as $p)
                                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('publisher')
                                        <small class="form-txt text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>* Select Author</label>
                                    <select name="author" class="form-control select2" style="width: 100%;">
                                        <option selected="selected">Open this to select Author</option>
                                        @foreach ($authors as $a)
                                            <option value="{{ $a->id }}">{{ $a->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('author')
                                        <small class="form-txt text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>* Select Category(s)</label>
                                    <div class="select2-purple">
                                        <select name="categories[]" class="select2" multiple="multiple"
                                            data-placeholder="Select a Category" data-dropdown-css-class="select2-purple"
                                            style="width: 100%;">
                                            @foreach ($categories as $c)
                                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('categories')
                                            <small class="form-txt text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">Add</button>
                        </div>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div><!-- /.container-fluid -->
    </section>
@endsection


@section('scripts')
    <!-- Select2 -->
    <script src="{{ URL::asset('back/plugins/select2/js/select2.full.min.js') }}"></script>

    <script>
        $(function() {

            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        });
    </script>
@endsection
