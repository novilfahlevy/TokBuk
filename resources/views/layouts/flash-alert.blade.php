@if ( ($message = Session::get('message')) && ($type = Session::get('type')) )
<div class="alert alert-{{ $type }} alert-dismissible fade show">
  {{ $message }}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif