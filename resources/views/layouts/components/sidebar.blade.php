<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
<a href="{{ url('/') }}" class="brand-link">
  @php
    $userPosisi = auth()->user()->posisi; // Ambil posisi user yang login
    $logoPath = 'tamplates/dist/img/AdminLTELogo.png'; // Default logo
    $brandText = 'Admin'; // Default brand text

    if ($userPosisi === 'admin') {
      $logoPath = 'tamplates/dist/img/AdminLogo.png'; // Logo untuk admin
      $brandText = 'Administrator';
    } elseif ($userPosisi === 'kasir') {
      $logoPath = 'tamplates/dist/img/KasirLogo.png'; // Logo untuk kasir
      $brandText = 'Kasir';
    }
  @endphp

  <img src="{{ asset($logoPath) }}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
  <span class="brand-text font-weight-light">{{ $brandText }}</span>
</a>


  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{ asset('tamplates/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">{{ auth()->user()->name }}</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      @php
    // Menu default untuk semua pengguna
    $menus = [
        (object)[
            "title" => "Dashboard",
            "path" => "dashboard",
            "icon" => "fas fa-th",
        ],
    ];

    // Tambahkan menu khusus kasir
    if (auth()->user()->posisi === "kasir") {
        $menus[] = (object)[
            "title" => "Transaksi",
            "path" => route('pages.transactions.index'),
            "icon" => "fas fa-exchange-alt",
        ];
    }

    // Tambahkan menu khusus admin
    if (auth()->user()->posisi === "admin") {
    $menus[] = (object)[
        "title" => "Produk",
        "path" => "#",
        "icon" => "fas fa-box",
        "submenu" => [
            (object)[
                "title" => "Kelola Produk",
                "path" => route('pages.products.index'),
            ],
            (object)[
                "title" => "Kelola Satuan",
                "path" => route('pages.units.index'),
            ],
            (object)[
                "title" => "Master Produk",
                "path" => route('pages.master_products.index'),
            ],
        ],
    ];

    $menus[] = (object)[
        "title" => "Kategori",
        "path" => "categories",
        "icon" => "fas fa-tags",
    ];

    $menus[] = (object)[
        "title" => "Pengguna",
        "path" => "penggunas",
        "icon" => "fas fa-users",
    ];

    // Tambahkan menu Laporan
    $menus[] = (object)[
        "title" => "Laporan",
        "path" => route('pages.laporan.index'), // Rute menuju halaman laporan
        "icon" => "fas fa-chart-bar",
    ];
}

@endphp

      <ul class="nav nav-pills nav-sidebar flex-column" role="menu" data-accordion="false">
        @foreach ($menus as $menu)
          <li class="nav-item {{ isset($menu->submenu) ? 'has-treeview ' . (collect($menu->submenu)->contains(fn($submenu) => request()->is(ltrim($submenu->path, '/'))) ? 'menu-open' : '') : '' }}">
            <a href="{{ $menu->path }}" class="nav-link {{ request()->is(ltrim($menu->path, '/')) ? 'active' : '' }}" onclick="toggleSubMenu(event, '{{ $menu->title }}', this)">
              <i class="nav-icon {{ $menu->icon }}"></i>
              <p>
                {{ $menu->title }}
                @if (isset($menu->submenu))
                  <i class="right fas fa-angle-left arrow {{ collect($menu->submenu)->contains(fn($submenu) => request()->is(ltrim($submenu->path, '/'))) ? 'rotate' : '' }}"></i>
                @endif
              </p>
            </a>

            @if (isset($menu->submenu))
              <ul class="nav nav-treeview" id="{{ $menu->title }}" style="{{ collect($menu->submenu)->contains(fn($submenu) => request()->is(ltrim($submenu->path, '/'))) ? 'display: block;' : 'display: none;' }}">
                @foreach ($menu->submenu as $submenu)
                  <li class="nav-item">
                    <a href="{{ $submenu->path }}" class="nav-link {{ request()->is(ltrim($submenu->path, '/')) ? 'active' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
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

<script>
function toggleSubMenu(event, menuTitle, element) {
    const submenu = document.getElementById(menuTitle);
    const arrow = element.querySelector('.arrow'); // Ambil elemen panah

    if (submenu) {
        event.preventDefault(); // Mencegah navigasi default hanya jika ada submenu
        // Toggle display style
        if (submenu.style.display === "none" || submenu.style.display === "") {
            submenu.style.display = "block"; // Tampilkan submenu
            arrow.classList.add('rotate'); // Tambahkan kelas untuk rotasi
        } else {
            submenu.style.display = "none"; // Sembunyikan submenu
            arrow.classList.remove('rotate'); // Hapus kelas untuk rotasi
        }
    }
}
</script>

<style>
.arrow {
    transition: transform 0.3s ease; /* Transisi untuk rotasi */
}

.rotate {
    transform: rotate(90deg); /* Rotasi panah 90 derajat */
}
</style>
