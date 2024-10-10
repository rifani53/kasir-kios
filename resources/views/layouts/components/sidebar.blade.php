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
  
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" role="menu" data-accordion="false">
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
                "submenu" => [
                  (object)[
                    "title" => "Kelola Produk",
                    "path" => route('pages.products.index'),
                  ],
                  (object)[
                    "title" => "Kelola Satuan",
                    "path" => route('pages.units.index'),
                  ]
                ],
              ],
              (object)[
                "title" => "Kategori",
                "path" => "categories",
                "icon" => "fas fa-tags",
              ],
              (object)[
                "title" => "Pengguna",
                "path" => "penggunas",
                "icon" => "fas fa-users",
              ],
            ];
          @endphp
  
          @foreach ($menus as $menu)
            <li class="nav-item {{ isset($menu->submenu) ? 'has-treeview' : '' }}">
              <a href="{{ $menu->path }}" class="nav-link {{ request()->is(ltrim($menu->path, '/')) ? 'active' : '' }}">
                <i class="nav-icon {{ $menu->icon }}"></i>
                <p>
                  {{ $menu->title }}
                  @if (isset($menu->submenu))
                    <i class="right fas fa-angle-left"></i>
                  @endif
                </p>
              </a>
  
              @if (isset($menu->submenu))
                <ul class="nav nav-treeview">
                  @foreach ($menu->submenu as $submenu)
                    <li class="nav-item">
                      <a href="{{ $submenu->path }}" class="nav-link {{ request()->is(ltrim($submenu->path, '/')) ? 'active' : '' }}">
                        <p>{{ $submenu->title }}</p>
                      </a>
                    </li>
                  @endforeach
                </ul>
              @endif
            </li>
          @endforeach
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
  