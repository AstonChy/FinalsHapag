@extends('layout')

@section('content')
<div style="max-width: 420px; margin: 3.5rem auto 0; text-align: center;">
  <div style="display: inline-flex; align-items: center; justify-content: center; width: 64px; height: 64px; border-radius: 50%; background: var(--apple-pastel-mint); border: 1px solid var(--apple-pastel-mint-border); color: var(--apple-sage); margin-bottom: 1.25rem; box-shadow: 0 4px 16px rgba(45, 106, 79, 0.12);">
    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
      <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
      <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
    </svg>
  </div>
  <h1 style="font-size: 2rem; margin-bottom: 0.35rem;">Staff Access</h1>
  <p class="muted" style="margin-bottom: 1.75rem;">Enter your administrator security passkey to continue.</p>

  <form class="card" method="POST" action="{{ route('admin.login') }}" style="padding: 2.25rem; text-align: left;">
    @csrf
    
    <label for="password">Admin Password</label>
    <input id="password" type="password" name="password" placeholder="Enter password" required autofocus>
    @error('password')<p class="err">{{ $message }}</p>@enderror

    <div style="margin-top: 1.75rem;">
      <button class="btn" style="width: 100%; padding: 0.9rem; font-size: 1rem;">
        Authenticate
      </button>
    </div>
  </form>
</div>
@endsection
