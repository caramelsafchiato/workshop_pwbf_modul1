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

    <li class="nav-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('profile.index') }}">
        <span class="menu-title">Pengaturan Profil</span>
        <i class="mdi mdi-account-settings menu-icon"></i>
      </a>
    </li>

  </ul>
</nav>