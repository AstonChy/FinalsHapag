@extends('layout')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.75rem; flex-wrap: wrap; gap: 1rem;">
  <div>
    <h1 style="margin-bottom: 0.25rem;">Dining Tables</h1>
    <p class="muted" style="margin-bottom: 0;">Configure restaurant capacity, seating allocation, and availability.</p>
  </div>
  <a class="btn" href="{{ route('admin.tables.create') }}">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 0.4rem;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
    Add New Table
  </a>
</div>

@error('table')
  <div class="flash" style="background: rgba(255, 59, 48, 0.12); border-color: rgba(255, 59, 48, 0.25); color: var(--apple-red);">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
    {{ $message }}
  </div>
@enderror

<div class="card tablewrap" style="padding: 0;">
  <table>
    <thead>
      <tr>
        <th>Table Name</th>
        <th>Seating Capacity</th>
        <th>Availability</th>
        <th>Total Bookings</th>
        <th style="text-align: right;">Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse($tables as $t)
      <tr>
        <td>
          <strong style="font-size: 0.95rem; font-weight: 600;">{{ $t->name }}</strong>
        </td>
        <td>
          <span style="font-weight: 500;">{{ $t->capacity }} seats</span>
        </td>
        <td>
          @if($t->is_active)
            <span class="badge confirmed">Active</span>
          @else
            <span class="badge" style="background: rgba(142, 142, 147, 0.15); color: #636366;">Inactive</span>
          @endif
        </td>
        <td>
          <span style="font-weight: 500; color: var(--apple-text);">{{ $t->reservations_count }}</span>
          <span style="font-size: 0.8rem; color: var(--apple-muted);">reservations</span>
        </td>
        <td style="text-align: right; white-space: nowrap;">
          <a class="btn sm ghost" href="{{ route('admin.tables.edit', $t) }}">Edit</a>
          <form class="inline" method="POST" action="{{ route('admin.tables.destroy', $t) }}" onsubmit="return confirm('Delete {{ $t->name }}? Tables with existing reservations cannot be removed.')">
            @csrf
            @method('DELETE')
            <button class="btn red sm" style="margin-left: 0.35rem;">Delete</button>
          </form>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="5" style="text-align: center; padding: 3rem 1rem; color: var(--apple-muted);">
          No dining tables configured yet.
        </td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
