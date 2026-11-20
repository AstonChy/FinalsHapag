@extends('layout')

@section('content')
<div style="max-width: 480px; margin: 1rem auto;">
  <div style="margin-bottom: 1.5rem;">
    <a href="{{ route('admin.tables.index') }}" style="font-size: 0.85rem; color: var(--apple-sage); text-decoration: none; display: inline-flex; align-items: center; gap: 0.35rem; margin-bottom: 0.75rem; font-weight: 600;">
      &larr; Back to Tables
    </a>
    <h1 style="margin-bottom: 0.25rem;">{{ $table->exists ? 'Edit Dining Table' : 'Add Dining Table' }}</h1>
    <p class="muted" style="margin-bottom: 0;">Specify table identifier and maximum party capacity.</p>
  </div>

  <form class="card" method="POST" action="{{ $table->exists ? route('admin.tables.update', $table) : route('admin.tables.store') }}" style="padding: 2.25rem;">
    @csrf
    @if($table->exists)
      @method('PUT')
    @endif

    <div>
      <label for="name">Table Name / Number</label>
      <input id="name" name="name" value="{{ old('name', $table->name) }}" placeholder="e.g. Table 1, Terrace Booth A" required autofocus>
      @error('name')<p class="err">{{ $message }}</p>@enderror
    </div>

    <div style="margin-top: 0.5rem;">
      <label for="capacity">Maximum Seating Capacity</label>
      <input id="capacity" type="number" name="capacity" min="1" max="20" value="{{ old('capacity', $table->capacity ?? 4) }}" required>
      @error('capacity')<p class="err">{{ $message }}</p>@enderror
    </div>

    <div style="margin: 1.5rem 0 1.75rem; padding: 1.1rem; background: var(--apple-pastel-mint); border: 1px solid var(--apple-pastel-mint-border); border-radius: 14px; display: flex; align-items: center; justify-content: space-between;">
      <div>
        <strong style="display: block; font-size: 0.92rem; color: var(--apple-text);">Active Status</strong>
        <span style="font-size: 0.8rem; color: var(--apple-muted);">Available for automatic booking assignment</span>
      </div>
      <label style="margin: 0; cursor: pointer;">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $table->exists ? $table->is_active : true)) style="width: 20px; height: 20px; accent-color: var(--apple-sage); cursor: pointer;">
      </label>
    </div>

    <div style="display: flex; gap: 0.75rem; align-items: center;">
      <button class="btn" style="padding: 0.75rem 1.75rem;">{{ $table->exists ? 'Save Changes' : 'Create Table' }}</button>
      <a class="btn ghost sm" href="{{ route('admin.tables.index') }}" style="padding: 0.75rem 1.25rem;">Cancel</a>
    </div>
  </form>
</div>
@endsection
