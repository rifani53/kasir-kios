@php
  $menus = [
    (object)[
      "title" => "Dashboard",
      "path" => "/",
      "icon" => "fas fa-th",
    ],
    (object)[
      "title" => "Produk",
      "path" => "/products",
      "icon" => "fas fa-box",
    ],
    (object)[
      "title" => "Kategori",
      "path" => route('pages.categories.index'),
      "icon" => "fas fa-tags",
    ],
    (object)[
      "title" => "Pengguna", // Menambahkan menu Pengguna
      "path" => route('pages.penggunas.index'), // Rute ke halaman pengguna
      "icon" => "fas fa-users",
    ],
  ];
@endphp

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="brand-link">
      <img src="{{ asset('tamplates/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Admin</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="{{ asset('tamplates/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Rifani</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Iterasi menu dinamis -->
          @foreach ($menus as $menu)
            <li class="nav-item">
              <a href="{{ $menu->path }}" class="nav-link {{ request()->path() === ltrim($menu->path, '/') ? 'active' : '' }}">
                <i class="nav-icon {{ $menu->icon }}"></i> <!-- Gunakan field icon di sini -->
                <p>
                  {{ $menu->title }}
                </p>
              </a>
            </li>
          @endforeach
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
