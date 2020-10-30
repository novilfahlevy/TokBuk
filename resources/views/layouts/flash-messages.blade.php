@php
$warna = session()->get('type') == 'success' ? '#8FBC8F' : '#F44336';
@endphp
@if (session()->has('message'))
    <div class="alert alert-{{ session()->get('type') == 'success' ? 'success' : 'danger' }} alert-dismissible alert-auto-close" role="alert" style="background: {{$warna}} !important; color: white;">
      {{ session()->get('message') }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
@endif

  @if($errors->isNotEmpty())
    <div class="alert alert-danger alert-dismissible" role="alert" style="background: #F44336 !important; color: white;">
      <small><strong>Kesalahan!</strong></small>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <hr>
      <ul class="list-group">
        @foreach($errors->all() as $error)
        <li class="list-group-item py-2 bg-danger border-0 small font-weight-bold mb-2">{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  {{-- @if ($errors->any())
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert">×</button> 
        Please check the form below for errors
    </div>
  @endif --}}