@extends('web::layouts.grids.12')

@section('title', 'Sharkord Role Mapping')
@section('page_header', 'Sharkord Role Mapping')

@section('full')
@if(session('status'))<div class="alert alert-success">{{ session('status') }}</div>@endif
<div class="card mb-3">
  <div class="card-header">Add / Update Mapping</div>
  <div class="card-body">
    <form method="POST" action="{{ route('sharkord-connector.mappings.store') }}">@csrf
      <div class="row">
        <div class="col"><input class="form-control" name="source_type" placeholder="group" required></div>
        <div class="col"><input class="form-control" name="source_key" placeholder="seat-group-key" required></div>
        <div class="col"><input class="form-control" name="source_label" placeholder="SeAT Group Label" required></div>
        <div class="col"><input class="form-control" name="sharkord_role_key" placeholder="sharkord-role-key" required></div>
        <div class="col"><select class="form-control" name="sync_mode"><option value="authoritative">authoritative</option><option value="additive">additive</option></select></div>
        <div class="col"><button class="btn btn-primary">Save</button></div>
      </div>
    </form>
  </div>
</div>
<div class="card">
  <div class="card-header">Current mappings</div>
  <div class="card-body">
    <table class="table table-sm"><thead><tr><th>Source</th><th>Label</th><th>Sharkord Role</th><th>Mode</th><th></th></tr></thead><tbody>
      @forelse($mappings as $mapping)
      <tr>
        <td>{{ $mapping->source_type }}:{{ $mapping->source_key }}</td>
        <td>{{ $mapping->source_label }}</td>
        <td>{{ $mapping->sharkord_role_key }}</td>
        <td>{{ $mapping->sync_mode }}</td>
        <td><form method="POST" action="{{ route('sharkord-connector.mappings.destroy', $mapping) }}">@csrf @method('DELETE')<button class="btn btn-sm btn-danger">Delete</button></form></td>
      </tr>
      @empty
      <tr><td colspan="5">No mappings configured.</td></tr>
      @endforelse
    </tbody></table>
  </div>
</div>
@endsection
