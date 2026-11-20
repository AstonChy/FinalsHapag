@extends('layout')

@section('content')
<div class="hero-visual" style="max-width: 1000px; margin: 0 auto 2.25rem; padding: clamp(2rem, 6vw, 4.2rem);">
  <div style="position:relative; z-index:1; max-width: 680px;">
  <span style="display:inline-block; font-size:0.8rem; font-weight:600; text-transform:uppercase; letter-spacing:0.08em; color:var(--apple-sage); background:var(--apple-pastel-mint); border: 1px solid var(--apple-pastel-mint-border); padding:0.4rem 1rem; border-radius:9999px; margin-bottom:0.85rem;">
    Hapag dining
  </span>
  <h1 style="font-size: clamp(2.2rem, 6vw, 4rem); color:#fffaf4; letter-spacing: -0.05em; margin-bottom: 0.85rem;">
    Good food. Warm tables. Memorable nights.
  </h1>
  <p style="color:rgba(255,250,244,.78); font-size: 1.05rem; line-height: 1.7; margin-bottom: 0;">
    Choose your Hapag location, reserve a table in a few moments, and we will send the confirmation straight to your inbox.
  </p>
  </div>
</div>

<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:1rem; max-width:1000px; margin:0 auto 2rem;">
  @foreach($locations as $location)
    <a href="#reservation-form" onclick="document.getElementById('restaurant').value='{{ $location['name'] }}'" style="text-decoration:none; color:inherit;">
      <article class="card location-card" style="height:100%; padding:1.5rem; border-top:4px solid {{ $location['accent'] }};">
        <div style="display:flex; justify-content:space-between; align-items:center; gap:.5rem; margin-bottom:.75rem;">
          <span style="font-size:1.15rem; font-weight:700; color:var(--apple-text);">{{ $location['name'] }}</span>
          <span style="font-size:.75rem; color:var(--apple-muted);">{{ $location['area'] }}</span>
        </div>
        <p class="muted" style="font-size:.9rem; line-height:1.5; min-height:4.1rem; margin-bottom:.8rem;">{{ $location['description'] }}</p>
        <span style="font-size:.8rem; color:{{ $location['accent'] }}; font-weight:600;">{{ $location['hours'] }} · Reserve here →</span>
      </article>
    </a>
  @endforeach
</div>

<form id="reservation-form" class="card" method="POST" action="{{ route('booking.store') }}" style="max-width: 760px; margin: 0 auto; padding: clamp(1.35rem, 4vw, 2.75rem);">
  @csrf
  
  <div style="margin-bottom: 1.75rem; border-bottom: 1px solid var(--apple-border); padding-bottom: 1rem;">
    <h3 style="margin: 0; font-size: 1.15rem; color: var(--apple-text);">Your Reservation</h3>
    <span style="font-size: 0.85rem; color: var(--apple-muted);">Your confirmation will be sent to the email address below.</span>
  </div>

  <div style="margin-bottom: .75rem;">
    <label for="restaurant">Restaurant Location</label>
    <select id="restaurant" name="restaurant" required>
      @foreach($locations as $location)
        <option value="{{ $location['name'] }}" @selected(old('restaurant', $locations[0]['name'])==$location['name'])>{{ $location['name'] }} — {{ $location['area'] }}</option>
      @endforeach
    </select>
    @error('restaurant')<p class="err">{{ $message }}</p>@enderror
  </div>

  <div class="grid">
    <div>
      <label for="name">Full Name</label>
      <input id="name" name="name" value="{{ old('name') }}" placeholder="e.g. Maria Santos" required autocomplete="name">
      @error('name')<p class="err">{{ $message }}</p>@enderror
    </div>
    <div>
      <label for="email">Email Address</label>
      <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="maria@example.com" required autocomplete="email">
      @error('email')<p class="err">{{ $message }}</p>@enderror
    </div>
  </div>

  <div class="grid" style="margin-top: 0.5rem;">
    <div>
      <label for="phone">Phone Number</label>
      <input id="phone" name="phone" value="{{ old('phone') }}" placeholder="0917 123 4567" required autocomplete="tel">
      @error('phone')<p class="err">{{ $message }}</p>@enderror
    </div>
    <div>
      <label for="guests">Party Size</label>
      <input id="guests" type="number" name="guests" min="1" max="12" value="{{ old('guests', 2) }}" required>
      @error('guests')<p class="err">{{ $message }}</p>@enderror
    </div>
  </div>

  <div style="margin: 2rem 0 1.75rem; border-bottom: 1px solid var(--apple-border); padding-bottom: 1rem;">
    <h3 style="margin: 0; font-size: 1.15rem; color: var(--apple-text);">Schedule & Payment</h3>
    <span style="font-size: 0.85rem; color: var(--apple-muted);">Select your preferred dining time and deposit method.</span>
  </div>

  <div class="grid">
    <div>
      <label for="date">Reservation Date</label>
      <input id="date" type="date" name="date" min="{{ date('Y-m-d') }}" value="{{ old('date', date('Y-m-d')) }}" required>
      @error('date')<p class="err">{{ $message }}</p>@enderror
    </div>
    <div>
      <label for="time">Dining Time Slot</label>
      <select id="time" name="time" required>
        @foreach(config('restaurant.slots') as $s)
          <option value="{{ $s }}" @selected(old('time')==$s)>{{ date('g:i A', strtotime($s)) }}</option>
        @endforeach
      </select>
      @error('time')<p class="err">{{ $message }}</p>@enderror
    </div>
  </div>

  <div style="margin-top: 0.5rem;">
    <label for="method">Deposit Payment Method</label>
    <select id="method" name="method" required>
      <option value="gcash" @selected(old('method')=='gcash')>GCash (Instant Confirmation)</option>
      <option value="card" @selected(old('method')=='card')>Credit or Debit Card</option>
      <option value="cash" @selected(old('method')=='cash')>Pay at Restaurant (Holds 15 mins)</option>
    </select>
    @error('method')<p class="err">{{ $message }}</p>@enderror
  </div>

  <div style="margin-top: 0.5rem;">
    <label for="notes">Special Requests (Optional)</label>
    <textarea id="notes" name="notes" rows="2" placeholder="Dietary restrictions, celebrations, or seating preference...">{{ old('notes') }}</textarea>
    @error('notes')<p class="err">{{ $message }}</p>@enderror
  </div>

  <div style="margin-top: 2.25rem; display: flex; flex-direction: column; align-items: stretch; gap: 0.85rem;">
    <button class="btn" style="padding: 1rem; font-size: 1.05rem;">
      Confirm Table Reservation
    </button>
    <div style="display:flex; justify-content:center; align-items:center; gap:0.45rem; color:var(--apple-muted); font-size:0.82rem;">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--apple-sage)" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
      <span>Safe Database Transaction Processing &middot; Instant Confirmation Email</span>
    </div>
  </div>
</form>
@endsection
