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

    <hr class="mx-3" style="border-color: rgba(255,255,255,0.1)">

    @if(Auth::check() && Auth::user()->role == 'admin')
      <li class="nav-item">
        <span class="nav-link" style="font-size: 11px; color: #9c9fa6; text-transform: uppercase;">Menu Admin</span>
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

      <li class="nav-item {{ request()->routeIs('pdf.*') ? 'active' : '' }}">
        <a class="nav-link" data-bs-toggle="collapse" href="#ui-pdf" aria-expanded="false" aria-controls="ui-pdf">
          <span class="menu-title">Cetak Dokumen</span>
          <i class="menu-arrow"></i>
          <i class="mdi mdi-certificate menu-icon"></i>
        </a>
        <div class="collapse" id="ui-pdf">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="{{ route('pdf.sertifikat') }}" target="_blank">Sertifikat</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{ route('pdf.pengumuman') }}" target="_blank">Pengumuman</a></li>
          </ul>
        </div>
      </li>

      <li class="nav-item {{ request()->routeIs('barang.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('barang.index') }}">
          <span class="menu-title">Tag Harga UMKM</span>
          <i class="mdi mdi-tag-multiple menu-icon"></i>
        </a>
      </li>

      <li class="nav-item {{ request()->routeIs('kasir.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('kasir.ajax') }}">
          <span class="menu-title">Kasir (AJAX)</span>
          <i class="mdi mdi-ajax menu-icon"></i>
        </a>
      </li>

      <li class="nav-item">
          <a class="nav-link" href="{{ route('admin.scan') }}">
              <span class="menu-title">Scanner Barcode</span>
              <i class="mdi mdi-barcode-scan menu-icon text-primary"></i>
          </a>
      </li>

      <li class="nav-item {{ request()->routeIs('lokasitoko.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('lokasitoko.index') }}">
          <span class="menu-title">Kunjungan Toko</span>
          <i class="mdi mdi-map-marker-radius menu-icon text-warning"></i>
        </a>
      </li>

      <li class="nav-item {{ request()->routeIs('user.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('user.index') }}">
          <span class="menu-title">Manajemen User</span>
          <i class="mdi mdi-account-group menu-icon"></i>
        </a>
      </li>
    @endif

    @if(Auth::check() && (strtolower(Auth::user()->role) == 'vendor' || Auth::user()->idvendor != null))
      <li class="nav-item">
        <span class="nav-link" style="font-size: 11px; color: #9c9fa6; text-transform: uppercase;">Menu Kantin (Vendor)</span>
      </li>

      <li class="nav-item {{ request()->routeIs('vendor.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('vendor.index') }}">
          <span class="menu-title">Kelola Menu</span>
          <i class="mdi mdi-food menu-icon"></i>
        </a>
      </li>

      <li class="nav-item {{ request()->routeIs('vendor.pesanan-lunas') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('vendor.pesanan-lunas') }}">
          <span class="menu-title">Pesanan Lunas</span>
          <i class="mdi mdi-cash-check menu-icon"></i>
        </a>
      </li>

      <li class="nav-item {{ request()->routeIs('vendor.scan') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('vendor.scan') }}">
          <span class="menu-title">Scan Pesanan QR</span>
          <i class="mdi mdi-qrcode-scan menu-icon text-info"></i>
        </a>
      </li>
    @endif

    @if(Auth::check() && Auth::user()->role == 'sales')
      <li class="nav-item">
        <span class="nav-link" style="font-size: 11px; color: #9c9fa6;">MENU SALES</span>
      </li>
      <li class="nav-item {{ request()->routeIs('sales.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('sales.dashboard') }}">
          <span class="menu-title">Dashboard Sales</span>
          <i class="mdi mdi-home menu-icon"></i>
        </a>
      </li>
      <li class="nav-item {{ request()->routeIs('lokasitoko.scan') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('lokasitoko.scan') }}">
          <span class="menu-title">Scan Kunjungan</span>
          <i class="mdi mdi-qrcode-scan menu-icon text-success"></i>
        </a>
      </li>
    @endif

    <hr class="mx-3" style="border-color: rgba(255,255,255,0.1)">

    <li class="nav-item">
      <span class="nav-link" style="font-size: 11px; color: #9c9fa6; text-transform: uppercase;">Layanan</span>
    </li>

    <li class="nav-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('profile.index') }}">
        <span class="menu-title">Pengaturan Profil</span>
        <i class="mdi mdi-account-settings menu-icon"></i>
      </a>
    </li>

    <li class="nav-item {{ request()->routeIs('pos.index') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('pos.index') }}">
        <span class="menu-title">Ke Kantin (POS)</span>
        <i class="mdi mdi-cart menu-icon"></i>
      </a>
    </li>

  </ul>
</nav>