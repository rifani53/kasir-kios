<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Aplikasi Kasir</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('tamplates/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('tamplates/dist/css/adminlte.min.css') }}">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('pages.dashboard.index') }}" class="nav-link">Home</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Tombol Logout -->
      <li class="nav-item">
        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
          @csrf
          <button type="submit" class="btn btn-link nav-link" style="color: inherit;">Logout</button>
        </form>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  @include('layouts.components.sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        @yield('header')
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      @yield('content')
    </section>
    <!-- /.content -->

    <a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top">
      <i class="fas fa-chevron-up"></i>
    </a>
  </div>
  <!-- /.content-wrapper -->

  {{-- <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.2.0
    </div>
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer> --}}

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('/tamplates/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset ('/tamplates/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('/tamplates/dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('/tamplates/dist/js/demo.js') }}"></script>


<style>

#suggestions {
    max-height: 200px;
    overflow-y: auto;
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 4px;
}

#suggestions .list-group-item {
    cursor: pointer;
}
</style>


<script>
    $(document).ready(function () {
        // Menangani input pada kolom pencarian
        $('#search').on('input', function () {
            const query = $(this).val();
            const suggestions = $('#suggestions');

            if (query.length > 0) {
                $.ajax({
                    url: "{{ route('transactions.search') }}",
                    type: 'GET',
                    data: { query: query },
                    success: function (data) {
                        let html = '';
                        data.forEach(function (item) {
                            html += `
                                <li class="list-group-item d-flex justify-content-between align-items-center"
                                    style="cursor: pointer;"
                                    data-id="${item.id}"
                                    data-nama="${item.nama}"
                                    data-harga="${item.harga}">
                                    ${item.nama} - Rp ${item.harga.toLocaleString('id-ID')}
                                </li>
                            `;
                        });
                        suggestions.html(html).show();
                    },
                });
            } else {
                suggestions.hide();
            }
        });

        // Menangani klik pada hasil sugesti
        $('#suggestions').on('click', 'li', function () {
            const id = $(this).data('id');
            const nama = $(this).data('nama');
            const harga = $(this).data('harga');

            // Misal: Tambahkan langsung ke keranjang
            const quantity = 1;
            $.ajax({
                url: "{{ route('transactions.cart.add') }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    product_id: id,
                    quantity: quantity,
                },
                success: function (response) {
                    alert('Produk berhasil ditambahkan ke keranjang.');
                    location.reload(); // Reload halaman untuk memperbarui keranjang
                },
                error: function (xhr) {
                    alert('Gagal menambahkan produk ke keranjang.');
                }
            });

            // Sembunyikan suggestions
            $('#suggestions').hide();
        });

        // Menyembunyikan sugesti jika klik di luar
        $(document).on('click', function (e) {
            if (!$(e.target).closest('#search, #suggestions').length) {
                $('#suggestions').hide();
            }
        });
    });
</script>
</body>
</html>
