<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
      <ul class="navbar-nav mr-3">
        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
      </ul>
    </form>
    <ul class="navbar-nav navbar-right">
      
      <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
      <img src="{{asset('assets/img/avatar/avatar-1.png')}}" alt="image" class="rounded-circle mr-1" style="width:35px; height:35px">
      <div class="d-sm-none d-lg-inline-block">
      Hi, {{strtoupper(auth()->user()->name)}}
        </div></a>
        <div class="dropdown-menu dropdown-menu-right">
          <a href="{{route('profil')}}" class="dropdown-item has-icon">
            <i class="far fa-user"></i> Profil
          </a>
          <div class="dropdown-divider"></div>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
          <a href="#" onclick="event.preventDefault();
          document.getElementById('logout-form').submit();" class="dropdown-item has-icon text-danger">
            <i class="fas fa-sign-out-alt"></i> Logout
          </a>
        </div>
      </li>
    </ul>
  </nav>