@extends('web::layouts.grids.12')

@section('title', 'Sharkord Account Link')
@section('page_header', 'Sharkord Account Link')

@section('full')
@if($status)
<div class="alert alert-success">{{ $status }}</div>
@endif

@if($credential)
<div class="alert alert-warning">
  <strong>One-time credential (shown once):</strong>
  @if(!empty($credential['temporary_password']))
    <div>Temporary password: <code>{{ $credential['temporary_password'] }}</code></div>
    <div>Must change password: <code>{{ $credential['must_change_password'] ? 'true' : 'false' }}</code></div>
  @endif
  @if(!empty($credential['password_setup_url']))
    <div>Password setup URL: <a href="{{ $credential['password_setup_url'] }}" target="_blank" rel="noopener">{{ $credential['password_setup_url'] }}</a></div>
  @endif
  @if(!empty($credential['password_setup_token']))
    <div>Password setup token: <code>{{ $credential['password_setup_token'] }}</code></div>
  @endif
</div>
@endif

<div class="card mb-3">
  <div class="card-header">Manual SeAT → Sharkord Flow</div>
  <div class="card-body d-flex gap-2">
    <form method="POST" action="{{ route('sharkord-connector.user-flow.link') }}">@csrf<button class="btn btn-primary">Link Sharkord</button></form>
    <form method="POST" action="{{ route('sharkord-connector.user-flow.resync') }}">@csrf<button class="btn btn-secondary">Re-sync Sharkord Access</button></form>
    <form method="POST" action="{{ route('sharkord-connector.user-flow.reset-password') }}">@csrf<button class="btn btn-warning">Reset Sharkord Password</button></form>
  </div>
</div>
@endsection
