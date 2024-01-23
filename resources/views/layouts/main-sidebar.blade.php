  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="{{ route('home') }}" class="brand-link">
          <img src="{{ URL::asset('back/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
              class="brand-image img-circle elevation-3" style="opacity: .8">
          <span class="brand-text font-weight-light">Aklam El Arab</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
              <div class="image">
                  <img src="{{ URL::asset('back/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                      alt="User Image">
              </div>
              <div class="info">
                  <a href="#" class="d-block">{{ Auth::user()->name }}</a>
              </div>
          </div>

          <!-- SidebarSearch Form -->
          <div class="form-inline">
              <div class="input-group" data-widget="sidebar-search">
                  <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                      aria-label="Search">
                  <div class="input-group-append">
                      <button class="btn btn-sidebar">
                          <i class="fas fa-search fa-fw"></i>
                      </button>
                  </div>
              </div>
          </div>

          <!-- Sidebar Menu -->
          <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                  data-accordion="false">
                  <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                  {{-- <li class="nav-item menu-open">
                      <a href="#" class="nav-link active">
                          <i class="nav-icon fas fa-tachometer-alt"></i>
                          <p>
                              Dashboard
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="./index.html" class="nav-link active">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Dashboard v1</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="./index2.html" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Dashboard v2</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="./index3.html" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Dashboard v3</p>
                              </a>
                          </li>
                      </ul>
                  </li> --}}
                  <li class="nav-header">Items</li>
                  <li class="nav-item">
                      <a href="{{ route('publisher') }}" class="nav-link">

                          <i class="fas fa-building"></i>
                          <p>
                              Publishing House
                              {{-- <span class="right badge badge-danger">New</span> --}}
                          </p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{ route('category') }}" class="nav-link">

                          <i class="fas fa-folder"></i>
                          <p>
                              Categories
                              {{-- <span class="right badge badge-danger">New</span> --}}
                          </p>
                      </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('book') }}" class="nav-link">

                        <i class="fas fa-book"></i>
                        <p>
                            Books
                            {{-- <span class="right badge badge-danger">New</span> --}}
                        </p>
                    </a>
                </li>
                  <li class="nav-item">
                      <a href="{{ route('advertisement') }}" class="nav-link">

                          <i class="fas fa-bullhorn"></i>
                          <p>
                              Advertisements
                              {{-- <span class="right badge badge-danger">New</span> --}}
                          </p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-copy"></i>
                          <p>
                              Users
                              <i class="fas fa-angle-left right"></i>
                              <span class="badge badge-info right">2</span>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{route('author')}}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Authors</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Readers</p>
                              </a>
                          </li>
                          
                      </ul>
                  </li>

                  <li class="nav-header">Settings</li>
                  {{-- <li class="nav-item">
                      <a href="pages/calendar.html" class="nav-link">
                          <i class="nav-icon far fa-calendar-alt"></i>
                          <p>
                              Calendar
                              <span class="badge badge-info right">2</span>
                          </p>
                      </a>
                  </li> --}}
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                          <form action="{{ route('logout') }}" method="POST">
                              @csrf
                              <button type="submit" class="btn btn-sm btn-outline-primary">Sign out</button>
                          </form>
                      </a>
                  </li>
                  {{-- <li class="nav-item">
                      <a href="#" class="nav-link">
                          <i class="nav-icon far fa-circle text-info"></i>
                          <p>Informational</p>
                      </a>
                  </li> --}}
              </ul>
          </nav>
          <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>
