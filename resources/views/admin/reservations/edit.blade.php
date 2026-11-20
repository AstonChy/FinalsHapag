@extends('layout')

@section('content')
<div style="max-width: 680px; margin: 0 auto;">
  <div style="margin-bottom: 1.5rem;">
    <a href="{{ route('admin.reservations.index') }}" style="font-size: 0.85rem; color: var(--apple-sage); text-decoration: none; display: inline-flex; align-items: center; gap: 0.35rem; margin-bottom: 0.75rem; font-weight: 600;">
      &larr; Back to Reservations
    </a>
    <h1 style="margin-bottom: 0.25rem;">Edit Reservation</h1>
    <p class="muted" style="margin-bottom: 0;">Update details for reference <span style="font-family: ui-monospace, Menlo, monospace; font-weight: 600; color: var(--apple-text);">{{ $reservation->reference }}</span></p>
  </div>

  <form class="card" method="POST" action="{{ route('admin.reservations.update', $reservation) }}" style="padding: 2.25rem;">
    @csrf
    @method('PUT')

    <div class="grid">
      <div>
        <label for="name">Guest Name</label>
        <input id="name" name="name" value="{{ old('name', $reservation->name) }}" required>
        @error('name')<p class="err">{{ $message }}</p>@enderror
      </div>
      <div>
        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email', $reservation->email) }}" required>
        @error('email')<p class="err">{{ $message }}</p>@enderror
      </div>
    </div>

    <div class="grid" style="margin-top: 0.5rem;">
      <div>
        <label for="phone">Phone</label>
        <input id="phone" name="phone" value="{{ old('phone', $reservation->phone) }}" required>
        @error('phone')<p class="err">{{ $message }}</p>@enderror
      </div>
      <div>
        <label for="guests">Guests (Pax)</label>
        <input id="guests" type="number" name="guests" min="1" max="12" value="{{ old('guests', $reservation->guests) }}" required>
        @error('guests')<p class="err">{{ $message }}</p>@enderror
      </div>
    </div>

    <div class="grid" style="margin-top: 0.5rem;">
      <div>
        <label for="date">Date</label>
        <input id="date" type="date" name="date" value="{{ old('date', $reservation->date->format('Y-m-d')) }}" required>
        @error('date')<p class="err">{{ $message }}</p>@enderror
      </div>
      <div>
        <label for="time">Time Slot</label>
        <select id="time" name="time">
          @foreach(config('restaurant.slots') as $s)
            <option value="{{ $s }}" @selected(old('time', $reservation->time)==$s)>{{ date('g:i A', strtotime($s)) }}</option>
          @endforeach
        </select>
        @error('time')<p class="err">{{ $message }}</p>@enderror
      </div>
    </div>

    <div class="grid" style="margin-top: 0.5rem;">
      <div>
        <label for="restaurant">Restaurant Location</label>
        <select id="restaurant" name="restaurant" required>
          @foreach(config('restaurant.locations') as $location)
            <option value="{{ $location['name'] }}" @selected(old('restaurant', $reservation->restaurant)==$location['name'])>{{ $location['name'] }} — {{ $location['area'] }}</option>
          @endforeach
        </select>
        @error('restaurant')<p class="err">{{ $message }}</p>@enderror
      </div>
      <div>
        <label for="dining_table_id">Assigned Table</label>
        <select id="dining_table_id" name="dining_table_id">
          @foreach($tables as $t)
            <option value="{{ $t->id }}" @selected(old('dining_table_id', $reservation->dining_table_id)==$t->id)>{{ $t->name }} (Seats up to {{ $t->capacity }})</option>
          @endforeach
        </select>
        @error('dining_table_id')<p class="err">{{ $message }}</p>@enderror
      </div>
      <div>
        <label for="status">Reservation Status</label>
        <select id="status" name="status">
          @foreach(['confirmed', 'completed', 'cancelled'] as $s)
            <option value="{{ $s }}" @selected(old('status', $reservation->status)==$s)>{{ ucfirst($s) }}</option>
          @endforeach
        </select>
        @error('status')<p class="err">{{ $message }}</p>@enderror
      </div>
    </div>

    <div style="margin-top: 0.5rem;">
      <label for="notes">Special Notes</label>
      <textarea id="notes" name="notes" rows="3">{{ old('notes', $reservation->notes) }}</textarea>
      @error('notes')<p class="err">{{ $message }}</p>@enderror
    </div>

    <div style="margin: 1.5rem 0; padding: 1rem 1.25rem; background: var(--apple-pastel-mint); border: 1px solid var(--apple-pastel-mint-border); border-radius: 14px; font-size: 0.88rem; color: #192a20; display: flex; align-items: center; gap: 0.75rem;">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--apple-sage)" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
      <span><strong>Transaction Protection:</strong> Marking status as <em>Cancelled</em> automatically executes a refund on any paid deposit record within a database transaction.</span>
    </div>

    @if($errors->any() && !$errors->has('time'))
      <p class="err" style="margin-bottom: 1rem;">{{ $errors->first() }}</p>
    @endif

    <div style="display: flex; gap: 0.75rem; align-items: center;">
      <button class="btn" style="padding: 0.75rem 1.75rem;">Save Changes</button>
      <a class="btn ghost sm" href="{{ route('admin.reservations.index') }}" style="padding: 0.75rem 1.25rem;">Cancel</a>
    </div>
  </form>
</div>
@endsection
