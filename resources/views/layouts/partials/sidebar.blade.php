<div class="main-sidebar pb-5">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand mt-0 mb-4 mt-2">
        <a href="{{route('home')}}" class="site_title">
          <img src="{{ asset('assets/img/logo.png') }}" width="160">
        </a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
      {{-- <a href="{{route('home')}}"><img src="{{asset('img/landingpage/logo.png')}}"  width="50px" alt=""></a> --}}
    </div>
    <br/>
    <ul class="sidebar-menu">
      @php $posisi = auth()->user()->posisi; @endphp
      
      <li class="menu-header">MENU UTAMA</li>

      <li class="nav-item {{Request::segment(1)=='home' ?'active':''}}">
        <a class="nav-link" href="{{route('home')}}" aria-expanded="false">
          <i class="fas fa-home"></i> <span>Dasbor</span>
        </a>
      </li>

      @if ( $posisi === 'Admin' || $posisi === 'Kasir' || $posisi === 'Owner' )
        <li class="nav-item {{Request::segment(1)=='transaksi' ?'active':''}}">
          <a class="nav-link" href="{{ route('transaksi') }}">
            <i class="fas fa-dollar-sign"></i><span>Transaksi</span>
          </a>
        </li>
      @endif

      @if ( $posisi === 'Admin' || $posisi === 'Operator' || $posisi === 'Owner' )
      <li class="nav-item  {{Request::segment(1)=='laporan' ?'active':''}}">
        <a class="nav-link" href="{{route('laporan')}}" aria-expanded="false">
          <i class="fas fa-file"></i> <span>Laporan</span>
        </a>
      </li>

        <li class="menu-header">MANAJEMEN BUKU</li>
      
        <li class="nav-item  {{Request::segment(1)=='buku' ?'active':''}}">
          <a class="nav-link" href="{{route('buku')}}" aria-expanded="false">
            <i class="fas fa-book"></i> <span>Buku</span>
          </a>
        </li>

        <li class="nav-item  {{Request::segment(1)=='pengadaan' ?'active':''}}">
          <a class="nav-link" href="{{route('pengadaan')}}" aria-expanded="false">
            <i class="fas fa-truck-loading"></i> <span>Pengadaan</span>
          </a>
        </li>

        <li class="dropdown{{ (Request::segment(1) === 'penulis' || Request::segment(1) === 'penerbit' || Request::segment(1) === 'kategori' || Request::segment(1) === 'distributor' || Request::segment(1) === 'lokasi') ? ' active' : '' }}">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-database"></i> <span>Data Master</span></a>
          <ul class="dropdown-menu{{ (Request::segment(1) === 'penulis' || Request::segment(1) === 'penerbit' || Request::segment(1) === 'kategori' || Request::segment(1) === 'distributor' || Request::segment(1) === 'lokasi') ? ' show' : '' }}">
            <li class="nav-item  {{Request::segment(1)=='penulis' ?'active':''}}">
              <a class="nav-link" href="{{route('penulis')}}" aria-expanded="false">
                <span>Penulis</span>
              </a>
            </li>
            <li class="nav-item  {{Request::segment(1)=='penerbit' ?'active':''}}">
              <a class="nav-link" href="{{route('penerbit')}}" aria-expanded="false">
                <span>Penerbit</span>
              </a>
            </li>
            <li class="nav-item  {{Request::segment(1)=='kategori' ?'active':''}}">
              <a class="nav-link" href="{{route('kategori')}}" aria-expanded="false">
                <span>Kategori</span>
              </a>
            </li>
            <li class="nav-item  {{Request::segment(1)=='distributor' ?'active':''}}">
              <a class="nav-link" href="{{route('distributor')}}" aria-expanded="false">
                <span>Distributor</span>
              </a>
            </li>
            <li class="nav-item  {{Request::segment(1)=='lokasi' ?'active':''}}">
              <a class="nav-link" href="{{route('lokasi')}}" aria-expanded="false">
                <span>Lokasi</span>
              </a>
            </li>
          </ul>
        </li>

      @endif

      @if ( $posisi === 'Admin' || $posisi === 'Owner' )
        <li class="menu-header">Lainnya</li>

        <li class="nav-item {{Request::segment(1)=='pengguna' ?'active':''}}">
          <a class="nav-link" href="{{route('user')}}" aria-expanded="false">
            <i class="fas fa-users"></i> <span>Pengguna</span>
          </a>
        </li>
      @endif

      @if ( $posisi === 'Admin' || $posisi === 'Owner' )
        <li class="nav-item  {{Request::segment(1)=='pengaturan' ?'active':''}}">
          <a class="nav-link" href="{{route('pengaturan')}}" aria-expanded="false">
            <i class="fas fa-cogs"></i></i><span>Pengaturan</span>
          </a>
        </li>
      @endif
  </aside>
</div>
