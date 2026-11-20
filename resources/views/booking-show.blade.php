@extends('layout')

@section('title', 'Reservation '.$reservation->reference)

@section('content')
<div style="max-width: 580px; margin: 1.5rem auto;">
  <div style="text-align: center; margin-bottom: 2rem;">
    <div style="display: inline-flex; align-items: center; justify-content: center; width: 68px; height: 68px; border-radius: 50%; background: var(--apple-pastel-mint); border: 1px solid var(--apple-pastel-mint-border); color: var(--apple-sage); margin-bottom: 1.25rem; box-shadow: 0 4px 16px rgba(45, 106, 79, 0.12);">
      <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <path d="M20 6L9 17l-5-5"/>
      </svg>
    </div>
    <h1 style="font-size: 2.35rem; margin-bottom: 0.35rem;">You're Booked!</h1>
    <p class="muted" style="margin-bottom: 0;">We look forward to hosting you, <strong>{{ $reservation->name }}</strong>.</p>
  </div>

  <div class="card" style="padding: 2.25rem; position: relative;">
    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--apple-border); padding-bottom: 1.25rem; margin-bottom: 1.5rem;">
      <div>
        <span style="font-size: 0.75rem; text-transform: uppercase; font-weight: 600; letter-spacing: 0.06em; color: var(--apple-muted); display: block;">Booking Reference</span>
        <span style="font-family: ui-monospace, Menlo, Monaco, Consolas, monospace; font-size: 1.4rem; font-weight: 700; color: var(--apple-text); letter-spacing: 0.04em;">
          {{ $reservation->reference }}
        </span>
      </div>
      <span class="badge {{ $reservation->status }}">{{ $reservation->status }}</span>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.75rem;">
      <div>
        <span style="font-size: 0.8rem; color: var(--apple-muted); display: block; margin-bottom: 0.25rem;">Date & Time</span>
        <strong style="font-size: 1rem; display: block; color: var(--apple-text);">{{ $reservation->date->format('D, M j, Y') }}</strong>
        <span style="font-size: 0.9rem; color: var(--apple-muted);">{{ date('g:i A', strtotime($reservation->time)) }}</span>
      </div>
      <div>
        <span style="font-size: 0.8rem; color: var(--apple-muted); display: block; margin-bottom: 0.25rem;">Table & Party</span>
        <strong style="font-size: 1rem; display: block; color: var(--apple-text);">{{ $reservation->restaurant }}</strong>
        <span style="font-size: 0.9rem; color: var(--apple-muted);">{{ $reservation->table->name }} · {{ $reservation->guests }} Guest{{ $reservation->guests > 1 ? 's' : '' }}</span>
      </div>
    </div>

    <div style="background: var(--apple-pastel-mint); border: 1px solid var(--apple-pastel-mint-border); border-radius: 16px; padding: 1.25rem; margin-bottom: 1.75rem;">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
        <span style="font-size: 0.85rem; color: var(--apple-muted); font-weight: 500;">Security Deposit</span>
        <div style="text-align: right;">
          <strong style="font-size: 1.15rem; color: var(--apple-text);">₱{{ number_format($reservation->payment->amount, 2) }}</strong>
          <span class="badge {{ $reservation->payment->status }}" style="margin-left: 0.4rem;">{{ $reservation->payment->status }}</span>
        </div>
      </div>
      <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.8rem; color: var(--apple-muted);">
        <span>Transaction Reference</span>
        <span style="font-family: ui-monospace, Menlo, Monaco, Consolas, monospace; font-weight: 600; color: var(--apple-text);">{{ $reservation->payment->transaction_ref }}</span>
      </div>
    </div>

    @if($reservation->notes)
      <div style="margin-bottom: 1.75rem; font-size: 0.88rem; color: var(--apple-muted); background: var(--apple-bg); padding: 1rem; border-radius: 12px;">
        <strong style="color: var(--apple-text); display: block; margin-bottom: 0.25rem;">Special Requests:</strong>
        {{ $reservation->notes }}
      </div>
    @endif

    <div style="text-align: center; border-top: 1px solid var(--apple-border); padding-top: 1.5rem;">
      <p style="font-size: 0.86rem; color: var(--apple-muted); margin: 0 0 1.25rem;">
        A confirmation receipt has been emailed to <strong>{{ $reservation->email }}</strong>.
      </p>
      <a class="btn" href="{{ route('home') }}" style="width: 100%; padding: 0.95rem;">
        Make Another Booking
      </a>
    </div>
  </div>
</div>
@endsection
