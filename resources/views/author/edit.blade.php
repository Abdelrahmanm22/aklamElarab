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
                    <h1 class="m-0">Profile</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Author Profile</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                @php
                                    if ($author->photo == null) {
                                        echo '<img class="profile-user-img img-fluid img-circle" src="' . URL::asset('Attachment/Users/dafault.jpeg') . '" alt="User profile picture">';
                                    } else {
                                        echo '<img class="profile-user-img img-fluid img-circle" src="' . URL::asset('Attachment/Users/' . $author->photo) . '"alt="User profile picture">';
                                    }
                                @endphp
                            </div>

                            <h3 class="profile-username text-center">{{ $author->name }}</h3>

                            {{-- <p class="text-muted text-center">Software Engineer</p> --}}

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Number Of Books</b> <a class="float-right">{{ $author->books()->count() }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Views</b>
                                    <a class="float-right">
                                        {{-- {{ $author->books()->sum('view') }} --}}
                                        @php
                                            if ($author->books()->sum('view') < 1000) {
                                                echo $author->books()->sum('view');
                                            } elseif ($author->books()->sum('view') < 1000000) {
                                                echo round($author->books()->sum('view') / 1000, 1) . 'K';
                                            } else {
                                                echo round($author->books()->sum('view') / 1000000, 1) . 'M';
                                            }
                                        @endphp
                                    </a>
                                    {{-- @php
                                        if ($b->view < 1000) {
                                            echo $b->view;
                                        } elseif ($b->view < 1000000) {
                                            echo round($b->view / 1000, 1) . 'K';
                                        } else {
                                            echo round($b->view / 1000000, 1) . 'M';
                                        }
                                    @endphp --}}
                                </li>
                                <li class="list-group-item">
                                    <b>Rate</b> <a class="float-right">
                                        @php
                                            $averageRating = $author->books()->avg('rate');
                                            $roundedRating = round($averageRating * 2) / 2; // Round to the nearest half
                                        @endphp

                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $roundedRating)
                                                <i class="fas fa-star"></i>
                                            @elseif ($i - 0.5 == $roundedRating)
                                                <i class="fas fa-star-half-alt"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        @endfor
                                    </a>
                                </li>
                            </ul>

                            @if ($author->related->facebook != null)
                                <!-- Facebook Icon -->
                                <a href="{{ $author->related->facebook }}" target="_blank" rel="noopener noreferrer"><i
                                        class="fab fa-facebook-square fa-2x"></i></a>
                            @endif

                            @if ($author->related->twitter != null)
                                <!-- Twitter Icon -->
                                <a href="{{ $author->related->twitter }}" target="_blank" rel="noopener noreferrer"><i
                                        class="fab fa-twitter-square fa-2x"></i></a>
                            @endif

                            {{-- <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> --}}
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- About Me Box -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">About Author</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <strong><i class="fas fa-book mr-1"></i>Brief about Author</strong>

                            <p class="text-muted">
                                {{ $author->related->about }}
                            </p>

                            {{-- <hr>

                      <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

                      <p class="text-muted">Malibu, California</p>

                      <hr>

                      <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>

                      <p class="text-muted">
                        <span class="tag tag-danger">UI Design</span>
                        <span class="tag tag-success">Coding</span>
                        <span class="tag tag-info">Javascript</span>
                        <span class="tag tag-warning">PHP</span>
                        <span class="tag tag-primary">Node.js</span>
                      </p>

                      <hr>

                      <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>

                      <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p> --}}
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#settings"
                                        data-toggle="tab">Information Settings</a></li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="settings">
                                    <form class="form-horizontal">
                                        <div class="form-group row">
                                            <label for="inputName" class="col-sm-1 col-form-label">Name</label>
                                            <div class="col-sm-5">
                                                <input disabled value="{{ $author->name }}" name="name" type="text"
                                                    class="form-control" id="inputName" placeholder="Name">
                                                @error('name')
                                                    <small class="form-txt text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <label for="inputEmail" class="col-sm-1 col-form-label">Email </label>
                                            <div class="col-sm-5">
                                                <input disabled name="email" type="email" class="form-control"
                                                    id="inputEmail" value="{{ $author->email }}" placeholder="Email">
                                                @error('email')
                                                    <small class="form-txt text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="inputEmail" class="col-sm-1 col-form-label">Birth Date</label>
                                            <div class="col-sm-5">
                                                <input disabled name="birthDate" type="date" class="form-control"
                                                    id="inputEmail" value="{{ $author->birthDate }}"
                                                    placeholder="Birth Date">
                                                @error('birthDate')
                                                    <small class="form-txt text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <label for="inputEmail" class="col-sm-1 col-form-label">Phone</label>
                                            <div class="col-sm-5">
                                                <input disabled name="phone" type="text" class="form-control"
                                                    id="inputEmail" value="{{ $author->phone }}" placeholder="Phone">
                                                @error('phone')
                                                    <small class="form-txt text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>


                                        <!-- ... (other form fields) ... -->
                                        {{-- <div class="form-group row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <button type="submit" class="btn btn-danger">Submit</button>
                                            </div>
                                        </div> --}}
                                    </form>
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    <div class="col-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h4 class="card-title">His own Books</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @foreach ($author->books as $b)
                                        <div class="col-sm-2 text-center">
                                            <a href="https://via.placeholder.com/1200/FFFFFF.png?text=1"
                                                data-toggle="lightbox" data-title="sample 1 - white"
                                                data-gallery="gallery">
                                                <img src="{{ URL::asset('Attachment/Books/Images/' . $b->author_id . '/' . $b->image) }}"
                                                    class="img-fluid mb-2" alt="white sample" />
                                                <p class="text-muted">{{ $b->name }}</p>
                                            </a>

                                        </div>
                                    @endforeach
                                    {{-- <div class="col-sm-2">
                                        <a href="https://via.placeholder.com/1200/000000.png?text=2"
                                            data-toggle="lightbox" data-title="sample 2 - black" data-gallery="gallery">
                                            <img src="https://via.placeholder.com/300/000000?text=2"
                                                class="img-fluid mb-2" alt="black sample" />
                                        </a>
                                    </div>
                                    <div class="col-sm-2">
                                        <a href="https://via.placeholder.com/1200/FF0000/FFFFFF.png?text=3"
                                            data-toggle="lightbox" data-title="sample 3 - red" data-gallery="gallery">
                                            <img src="https://via.placeholder.com/300/FF0000/FFFFFF?text=3"
                                                class="img-fluid mb-2" alt="red sample" />
                                        </a>
                                    </div>
                                    <div class="col-sm-2">
                                        <a href="https://via.placeholder.com/1200/FF0000/FFFFFF.png?text=4"
                                            data-toggle="lightbox" data-title="sample 4 - red" data-gallery="gallery">
                                            <img src="https://via.placeholder.com/300/FF0000/FFFFFF?text=4"
                                                class="img-fluid mb-2" alt="red sample" />
                                        </a>
                                    </div>
                                    <div class="col-sm-2">
                                        <a href="https://via.placeholder.com/1200/000000.png?text=5"
                                            data-toggle="lightbox" data-title="sample 5 - black" data-gallery="gallery">
                                            <img src="https://via.placeholder.com/300/000000?text=5"
                                                class="img-fluid mb-2" alt="black sample" />
                                        </a>
                                    </div>
                                    <div class="col-sm-2">
                                        <a href="https://via.placeholder.com/1200/FFFFFF.png?text=6"
                                            data-toggle="lightbox" data-title="sample 6 - white" data-gallery="gallery">
                                            <img src="https://via.placeholder.com/300/FFFFFF?text=6"
                                                class="img-fluid mb-2" alt="white sample" />
                                        </a>
                                    </div>
                                    <div class="col-sm-2">
                                        <a href="https://via.placeholder.com/1200/FFFFFF.png?text=7"
                                            data-toggle="lightbox" data-title="sample 7 - white" data-gallery="gallery">
                                            <img src="https://via.placeholder.com/300/FFFFFF?text=7"
                                                class="img-fluid mb-2" alt="white sample" />
                                        </a>
                                    </div>
                                    <div class="col-sm-2">
                                        <a href="https://via.placeholder.com/1200/000000.png?text=8"
                                            data-toggle="lightbox" data-title="sample 8 - black" data-gallery="gallery">
                                            <img src="https://via.placeholder.com/300/000000?text=8"
                                                class="img-fluid mb-2" alt="black sample" />
                                        </a>
                                    </div>
                                    <div class="col-sm-2">
                                        <a href="https://via.placeholder.com/1200/FF0000/FFFFFF.png?text=9"
                                            data-toggle="lightbox" data-title="sample 9 - red" data-gallery="gallery">
                                            <img src="https://via.placeholder.com/300/FF0000/FFFFFF?text=9"
                                                class="img-fluid mb-2" alt="red sample" />
                                        </a>
                                    </div>
                                    <div class="col-sm-2">
                                        <a href="https://via.placeholder.com/1200/FFFFFF.png?text=10"
                                            data-toggle="lightbox" data-title="sample 10 - white" data-gallery="gallery">
                                            <img src="https://via.placeholder.com/300/FFFFFF?text=10"
                                                class="img-fluid mb-2" alt="white sample" />
                                        </a>
                                    </div>
                                    <div class="col-sm-2">
                                        <a href="https://via.placeholder.com/1200/FFFFFF.png?text=11"
                                            data-toggle="lightbox" data-title="sample 11 - white" data-gallery="gallery">
                                            <img src="https://via.placeholder.com/300/FFFFFF?text=11"
                                                class="img-fluid mb-2" alt="white sample" />
                                        </a>
                                    </div>
                                    <div class="col-sm-2">
                                        <a href="https://via.placeholder.com/1200/000000.png?text=12"
                                            data-toggle="lightbox" data-title="sample 12 - black" data-gallery="gallery">
                                            <img src="https://via.placeholder.com/300/000000?text=12"
                                                class="img-fluid mb-2" alt="black sample" />
                                        </a>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
@endsection


@section('scripts')

@endsection
