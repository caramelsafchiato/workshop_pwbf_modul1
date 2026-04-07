<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item nav-profile">
      <a href="{{ route('profile.index') }}" class="nav-link">
        <div class="nav-profile-image">
          <img src="{{ asset('assets/images/faces/face1.jpg') }}" alt="profile" />
          <span class="login-status online"></span>
        </div>
        <div class="nav-profile-text d-flex flex-column">
          <span class="font-weight-bold mb-2">
            {{ Auth::check() ? Auth::user()->nama : 'Guest' }}
          </span>
          <span class="text-secondary text-small">
            {{ Auth::check() ? ucfirst(Auth::user()->role) : 'User' }}
          </span>
        </div>
        <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
      </a>
    </li>

    <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('dashboard') }}">
        <span class="menu-title">Dashboard</span>
        <i class="mdi mdi-home menu-icon"></i>
      </a>
    </li>

    <li class="nav-item {{ request()->routeIs('kategori.*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('kategori.index') }}">
        <span class="menu-title">Manajemen Kategori</span>
        <i class="mdi mdi-bookmark-outline menu-icon"></i>
      </a>
    </li>

    <li class="nav-item {{ request()->routeIs('buku.*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('buku.index') }}">
        <span class="menu-title">Koleksi Buku</span>
        <i class="mdi mdi-book-open-page-variant menu-icon"></i>
      </a>
    </li>

    <li class="nav-item {{ request()->routeIs('pdf.sertifikat') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('pdf.sertifikat') }}" target="_blank">
        <span class="menu-title">Cetak Sertifikat</span>
        <i class="mdi mdi-certificate menu-icon"></i>
      </a>
    </li>

    <li class="nav-item {{ request()->routeIs('pdf.pengumuman') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('pdf.pengumuman') }}" target="_blank">
        <span class="menu-title">Cetak Pengumuman</span>
        <i class="mdi mdi-file-document-outline menu-icon"></i>
      </a>
    </li>

    <li class="nav-item {{ request()->routeIs('barang.*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('barang.index') }}">
        <span class="menu-title">Tag Harga UMKM</span>
        <i class="mdi mdi-tag-multiple menu-icon"></i>
      </a>
    </li>

    <li class="nav-item {{ request()->routeIs('tabel_barang.index') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('tabel_barang.index') }}">
        <span class="menu-title">Simulasi Tabel JS</span>
        <i class="mdi mdi-table-edit menu-icon"></i>
      </a>
    </li>

    <li class="nav-item {{ request()->routeIs('kota.*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('kota.index') }}">
        <span class="menu-title">Manajemen Kota</span>
        <i class="mdi mdi-city menu-icon"></i>
      </a>
    </li>

    {{-- MENU BARU: WILAYAH AJAX --}}
    <li class="nav-item {{ request()->routeIs('wilayah.ajax') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('wilayah.ajax') }}">
        <span class="menu-title">Wilayah (AJAX)</span>
        <i class="mdi mdi-map-marker menu-icon"></i>
      </a>
    </li>

    {{-- MENU BARU: WILAYAH AXIOS --}}
    <li class="nav-item {{ request()->routeIs('wilayah.axios') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('wilayah.axios') }}">
        <span class="menu-title">Wilayah (Axios)</span>
        <i class="mdi mdi-map-marker-outline menu-icon"></i>
      </a>
    </li>

    <li class="nav-item {{ request()->routeIs('kasir.ajax') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('kasir.ajax') }}">
        <span class="menu-title">Kasir (AJAX)</span>
        <i class="mdi mdi-ajax menu-icon"></i>
      </a>
    </li>

    <li class="nav-item {{ request()->routeIs('kasir.axios') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('kasir.axios') }}">
        <span class="menu-title">Kasir (AXIOS)</span>
        <i class="mdi mdi-swap-horizontal menu-icon"></i>
      </a>
    </li>

    <li class="nav-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('profile.index') }}">
        <span class="menu-title">Pengaturan Profil</span>
        <i class="mdi mdi-account-settings menu-icon"></i>
      </a>
    </li>

  </ul>
</nav>