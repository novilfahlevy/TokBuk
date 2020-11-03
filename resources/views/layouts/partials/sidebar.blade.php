<div class="main-sidebar">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand mt-2 mb-5">
        <a href="{{route('home')}}" class="site_title">
          <img src="{{ asset('assets/img/logo.png') }}" alt="logo thortech project" class="img-fluid img-thumbnail mt-3 shadow-light rounded-pill px-4 py-2" style="height: 5em">
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

      @if ( $posisi === 'Admin' || $posisi === 'Kasir' )
        <li class="nav-item {{Request::segment(1)=='transaksi' ?'active':''}}">
          <a class="nav-link" href="{{ route('transaksi') }}">
            <i class="fas fa-dollar-sign"></i><span>Transaksi</span>
          </a>
        </li>
      @endif

      @if ( $posisi === 'Admin' || $posisi === 'Operator' )
        <li class="nav-item {{Request::segment(1)=='datauser' ?'active':''}}">
          <a class="nav-link" href="{{route('user')}}" aria-expanded="false">
            <i class="fas fa-users"></i> <span>Pengguna</span>
          </a>
        </li>

        <li class="menu-header">MANAJEMEN BUKU</li>
      
        <li class="nav-item  {{Request::segment(1)=='databuku' ?'active':''}}">
          <a class="nav-link" href="{{route('buku')}}" aria-expanded="false">
            <i class="fas fa-book"></i> <span>Buku</span>
          </a>
        </li>

        <li class="nav-item  {{Request::segment(1)=='pembelian-buku' ?'active':''}}">
          <a class="nav-link" href="{{route('pembelian-buku')}}" aria-expanded="false">
            <i class="fas fa-truck-loading"></i> <span>Pembelian Buku</span>
          </a>
        </li>

        <li class="menu-header">DATA MASTER</li>

        <li class="nav-item  {{Request::segment(1)=='penulis' ?'active':''}}">
          <a class="nav-link" href="{{route('penulis')}}" aria-expanded="false">
            <i class="fas fa-user-edit"></i><span>Penulis</span>
          </a>
        </li>
        <li class="nav-item  {{Request::segment(1)=='penerbit' ?'active':''}}">
          <a class="nav-link" href="{{route('penerbit')}}" aria-expanded="false">
            <i class="fas fa-building"></i></i><span>Penerbit</span>
          </a>
        </li>
        <li class="nav-item  {{Request::segment(1)=='kategori' ?'active':''}}">
          <a class="nav-link" href="{{route('kategori')}}" aria-expanded="false">
            <i class="fas fa-swatchbook"></i></i><span>Kategori</span>
          </a>
        </li>
        <li class="nav-item  {{Request::segment(1)=='pemasok' ?'active':''}}">
          <a class="nav-link" href="{{route('pemasok')}}" aria-expanded="false">
            <i class="fas fa-truck-moving"></i></i><span>Pemasok</span>
          </a>
        </li>
        <li class="nav-item  {{Request::segment(1)=='lokasi' ?'active':''}}">
          <a class="nav-link" href="{{route('lokasi')}}" aria-expanded="false">
            <i class="fas fa-table"></i></i><span>Lokasi</span>
          </a>
        </li>
      @endif
  </aside>
</div>
