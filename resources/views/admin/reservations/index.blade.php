@extends('layout')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
  <div>
    <h1 style="margin-bottom: 0.25rem;">Reservations</h1>
    <p class="muted" style="margin-bottom: 0;">Manage guest bookings, update statuses, and monitor deposit transactions.</p>
  </div>
</div>

<form class="card" method="GET" style="display: flex; gap: 1rem; flex-wrap: wrap; align-items: flex-end; margin-bottom: 1.5rem; padding: 1.25rem;">
  <div style="flex: 1; min-width: 180px;">
    <label style="margin-top: 0;" for="filter_date">Date</label>
    <input id="filter_date" type="date" name="date" value="{{ request('date') }}">
  </div>
  <div style="flex: 2; min-width: 220px;">
    <label style="margin-top: 0;" for="filter_q">Search Name or Reference</label>
    <input id="filter_q" name="q" placeholder="Search by name, ref (e.g. RSV-)..." value="{{ request('q') }}">
  </div>
  <div style="display: flex; gap: 0.5rem; align-items: center;">
    <button class="btn dark" style="padding: 0.72rem 1.25rem;">Filter</button>
    <a class="btn ghost sm" href="{{ route('admin.reservations.index') }}" style="padding: 0.72rem 1rem;">Reset</a>
  </div>
</form>

<div class="card tablewrap" style="padding: 0;">
  <table>
    <thead>
      <tr>
        <th>Reference</th>
        <th>Guest</th>
        <th>Schedule</th>
        <th>Table</th>
        <th>Guests</th>
        <th>Deposit / Txn</th>
        <th>Status</th>
        <th style="text-align: right;">Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse($reservations as $r)
      <tr>
        <td>
          <span style="font-family: ui-monospace, Menlo, monospace; font-weight: 600; font-size: 0.88rem;">{{ $r->reference }}</span>
        </td>
        <td>
          <strong style="display: block; font-weight: 600;">{{ $r->name }}</strong>
          <span style="font-size: 0.82rem; color: var(--apple-muted);">{{ $r->restaurant }} &middot; {{ $r->email }}</span>
        </td>
        <td>
          <span style="display: block; font-weight: 500;">{{ $r->date->format('M j, Y') }}</span>
          <span style="font-size: 0.82rem; color: var(--apple-muted);">{{ date('g:i A', strtotime($r->time)) }}</span>
        </td>
        <td>
          <span style="display: inline-block; font-weight: 500;">{{ $r->table->name }}</span>
        </td>
        <td>
          <span style="font-weight: 500;">{{ $r->guests }}</span>
        </td>
        <td>
          <span style="display: block; font-weight: 600;">₱{{ number_format($r->payment->amount ?? 0, 2) }}</span>
          <span class="badge {{ $r->payment->status ?? '' }}" style="font-size: 0.72rem;">{{ $r->payment->status ?? '-' }}</span>
        </td>
        <td>
          <span class="badge {{ $r->status }}">{{ $r->status }}</span>
        </td>
        <td style="text-align: right; white-space: nowrap;">
          <a class="btn sm ghost" href="{{ route('admin.reservations.edit', $r) }}">Edit</a>
          <form class="inline" method="POST" action="{{ route('admin.reservations.destroy', $r) }}" onsubmit="return confirm('Are you sure you want to permanently delete this reservation?')">
            @csrf
            @method('DELETE')
            <button class="btn red sm" style="margin-left: 0.35rem;">Delete</button>
          </form>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="8" style="text-align: center; padding: 3rem 1rem; color: var(--apple-muted);">
          No reservations found matching your criteria.
        </td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>

<div style="margin-top: 1.5rem;">
  {{ $reservations->links() }}
</div>
@endsection
