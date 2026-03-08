@extends('web::layouts.grids.12')

@section('title', 'Sharkord Connector Settings')
@section('page_header', 'Sharkord Connector')

@section('full')
@if(session('status'))<div class="alert alert-success">{{ session('status') }}</div>@endif
<div class="card">
  <div class="card-header">Connectivity & Sync Defaults</div>
  <div class="card-body">
    <form method="POST" action="{{ route('sharkord-connector.settings.update') }}">@csrf
      <div class="form-group"><label>Sharkord base URL</label><input class="form-control" name="sharkord_base_url" value="{{ old('sharkord_base_url', $settings->sharkord_base_url ?? '') }}" required></div>
      <div class="form-group"><label>API base path</label><input class="form-control" name="sharkord_api_base_path" value="{{ old('sharkord_api_base_path', $settings->sharkord_api_base_path ?? '/api/v1/ext') }}"></div>
      <div class="form-group"><label>Signing secret</label><input class="form-control" name="signing_secret_encrypted_or_protected" value="{{ old('signing_secret_encrypted_or_protected', $settings->signing_secret_encrypted_or_protected ?? '') }}" required></div>
      <div class="form-group"><label>Diagnostics bearer token</label><input class="form-control" name="diagnostics_bearer_token_encrypted_or_protected" value="{{ old('diagnostics_bearer_token_encrypted_or_protected', $settings->diagnostics_bearer_token_encrypted_or_protected ?? '') }}"></div>
      <div class="form-group"><label>Timeout (seconds)</label><input type="number" class="form-control" name="request_timeout_seconds" value="{{ old('request_timeout_seconds', $settings->request_timeout_seconds ?? 10) }}"></div>
      <button class="btn btn-primary">Save settings</button>
    </form>
  </div>
</div>
@endsection
