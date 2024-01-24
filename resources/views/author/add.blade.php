@extends('layouts.master')
@section('title')
    {{ $title }}
@stop

@section('css')

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
                        <li class="breadcrumb-item active">Add Author</li>
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
                    <h3 class="card-title">Form To Add Author</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{ route('author.create') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>* Name </label>
                                    <input type="text" name="name" class="form-control" value=""
                                        placeholder="Enter ..."  autocomplete="off">
                                    @error('name')
                                        <small class="form-txt text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>* Email</label>
                                    <input type="text" name="email" class="form-control" value=""
                                        placeholder="Enter ..." autocomplete="off">
                                    @error('email')
                                        <small class="form-txt text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>* Password</label>
                                    <input type="password" name="password" class="form-control" value=""
                                        placeholder="Enter ..."  autocomplete="off">
                                    @error('password')
                                        <small class="form-txt text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>* Confirm Password</label>
                                    <input type="password" name="password_confirmation" class="form-control" value=""
                                        placeholder="Enter ..."  autocomplete="off">

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>* Birth Date </label>
                                    <input type="date" name="birthDate" class="form-control" value=""
                                        placeholder="Enter ..." autocomplete="off">
                                    @error('birthDate')
                                        <small class="form-txt text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>* Phone </label>
                                    <input type="text" name="phone" class="form-control" value=""
                                        placeholder="Enter ..." autocomplete="off">
                                    @error('phone')
                                        <small class="form-txt text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <!-- file input -->
                                <div class="form-group">
                                    <label>Image Profile</label>
                                    <input type="file" name="photo" autocomplete="off" class="form-control">
                                    @error('photo')
                                        <small class="form-txt text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Facebook Link</label>
                                    <input type="text" name="facebook" class="form-control" value=""
                                        placeholder="Enter ..."  autocomplete="off">
                                    @error('facebook')
                                        <small class="form-txt text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Twitter Link</label>
                                    <input type="text" name="twitter" class="form-control" value=""
                                        placeholder="Enter ..."  autocomplete="off">
                                    @error('twitter')
                                        <small class="form-txt text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <!-- textarea -->
                                <div class="form-group">
                                    <label>About the Author</label>
                                    <textarea name="about" maxlength="2000" class="form-control" placeholder="Enter ..."  autocomplete="off" ></textarea>
                                    @error('about')
                                        <small class="form-txt text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4">
                                <label>* Gender </label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="sir"
                                        value="1">
                                    <label class="form-check-label" for="sir">Male</label>
                                </div>
                                <br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="lady"
                                        value="0">
                                    <label class="form-check-label" for="lady">Female</label>
                                </div>
                                @error('gender')
                                    <small class="form-txt text-danger">{{ $message }}</small>
                                @enderror
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

@endsection
