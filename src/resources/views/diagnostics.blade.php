@extends('web::layouts.grids.12')

@section('title', 'Sharkord Connector Diagnostics')

@section('page_header', 'Sharkord Connector Diagnostics')

@section('full')
<div class="card">
  <div class="card-header">Provider Health</div>
  <div class="card-body">
    <pre>{{ json_encode($health, JSON_PRETTY_PRINT) }}</pre>
  </div>
</div>
@endsection
