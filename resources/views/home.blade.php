@extends('layouts.partials.app')
@section('title')
  Dashboard
@endsection
@section('content')
  <div class="main-wrapper main-wrapper-1">
    <div class="main-content" style="min-height: 116px;">
        <section class="section">
          <div class="section-header">
                <h1>Dashboard</h1>
          </div>
          <div class="section-body">
          <h2>Welcome {{auth()->user()->name}}</h2>
          </div>
      </section>
    </div>
  </div>
@endsection
