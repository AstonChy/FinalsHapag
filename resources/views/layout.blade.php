<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title>@yield('title', config('restaurant.name'))</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
:root {
  /* Warm modern dining palette */
  --apple-bg: #f7f2eb;
  --apple-card: #fffdf9;
  --apple-text: #2c241f;
  --apple-muted: #776e63;
  --apple-border: rgba(77, 57, 42, 0.12);
  --apple-border-strong: rgba(77, 57, 42, 0.22);
  
  /* Primary Sage / Mint Accent */
  --apple-sage: #9a5b3f;
  --apple-sage-hover: #7f4933;
  --apple-sage-active: #5e3426;
  --apple-pastel-mint: #f5e5dc;
  --apple-pastel-mint-border: #e8c9b9;
  
  /* Status Colors with Soft Pastel Badges */
  --apple-green: #5b806b;
  --apple-red: #d9383a;
  --apple-amber: #c27803;
  --apple-blue: #227093;

  --apple-radius-card: 20px;
  --apple-radius-btn: 9999px;
  --apple-radius-input: 14px;
  --ease-spring: cubic-bezier(0.16, 1, 0.3, 1);
}

* { box-sizing: border-box; -webkit-tap-highlight-color: transparent; }

body {
  margin: 0;
  font-family: -apple-system, BlinkMacSystemFont, "Plus Jakarta Sans", "SF Pro Text", "SF Pro Display", "Helvetica Neue", Helvetica, Arial, sans-serif;
  background:
    radial-gradient(circle at 8% 0%, rgba(203, 139, 102, 0.12), transparent 28rem),
    linear-gradient(180deg, #fbf7f1 0%, var(--apple-bg) 42%, #f3ede5 100%);
  color: var(--apple-text);
  line-height: 1.5;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}

/* Frosted Glass Header with Pastel Hint */
header.top {
  position: sticky;
  top: 0;
  z-index: 100;
  background: rgba(255, 253, 249, 0.88);
  backdrop-filter: blur(20px) saturate(180%);
  -webkit-backdrop-filter: blur(20px) saturate(180%);
  border-bottom: 1px solid rgba(77, 57, 42, 0.1);
  padding: 1rem clamp(1rem, 4vw, 3.5rem);
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 1.5rem;
  transition: background 0.3s var(--ease-spring);
}

.brand {
  font-size: 1.2rem;
  font-weight: 700;
  color: var(--apple-text);
  text-decoration: none;
  letter-spacing: -0.03em;
  display: flex;
  align-items: center;
  gap: 0.55rem;
}

.brand-dot {
  width: 12px;
  height: 12px;
  background: var(--apple-sage);
  border-radius: 50%;
  display: inline-block;
  box-shadow: 0 0 0 4px rgba(154, 91, 63, 0.16);
}

nav {
  display: flex;
  align-items: center;
  gap: 0.4rem;
}

nav a {
  color: var(--apple-muted);
  text-decoration: none;
  font-size: 0.88rem;
  font-weight: 600;
  padding: 0.45rem 0.95rem;
  border-radius: 9999px;
  transition: all 0.2s var(--ease-spring);
}

nav a:hover {
  background: rgba(154, 91, 63, 0.09);
  color: var(--apple-sage);
}

main {
  max-width: 1120px;
  margin: 0 auto;
  padding: clamp(2rem, 5vw, 4.5rem) 1.25rem 5rem;
}

/* Pastel Floating Cards */
.card {
  background: var(--apple-card);
  border: 1px solid var(--apple-border);
  border-radius: var(--apple-radius-card);
  padding: 2rem;
  box-shadow: 0 18px 50px rgba(74, 48, 31, 0.07), 0 2px 5px rgba(74, 48, 31, 0.04);
  transition: transform 0.2s var(--ease-spring), box-shadow 0.2s var(--ease-spring);
}

.card:hover {
  box-shadow: 0 22px 58px rgba(74, 48, 31, 0.11), 0 3px 8px rgba(74, 48, 31, 0.05);
}

/* Typography */
h1 {
  font-size: 2.2rem;
  font-weight: 700;
  letter-spacing: -0.035em;
  line-height: 1.18;
  margin: 0 0 0.5rem;
  color: var(--apple-text);
}

h2 {
  font-size: 1.55rem;
  font-weight: 700;
  letter-spacing: -0.025em;
  margin: 0 0 0.5rem;
  color: var(--apple-text);
}

h3 {
  font-size: 1.15rem;
  font-weight: 600;
  letter-spacing: -0.015em;
  margin: 0 0 0.4rem;
  color: var(--apple-text);
}

p.muted {
  color: var(--apple-muted);
  font-size: 0.96rem;
  margin: 0 0 1.5rem;
}

/* Form Controls with Soft Pastel Focus */
label {
  display: block;
  font-size: 0.85rem;
  font-weight: 600;
  color: #2b3d32;
  margin: 0.95rem 0 0.35rem;
  letter-spacing: -0.01em;
}

input, select, textarea {
  width: 100%;
  padding: 0.78rem 1rem;
  border: 1px solid #dfd3c8;
  border-radius: var(--apple-radius-input);
  font-size: 0.95rem;
  font-family: inherit;
  color: var(--apple-text);
  background-color: #fffdfa;
  transition: all 0.2s var(--ease-spring);
  appearance: none;
}

select {
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath fill='none' stroke='%235e7468' stroke-width='1.8' stroke-linecap='round' stroke-linejoin='round' d='M1 1.5l5 5 5-5'/%3E%3C/svg%3E");
  background-repeat: no-repeat;
  background-position: right 1.1rem center;
  padding-right: 2.75rem;
}

input:focus, select:focus, textarea:focus {
  outline: none;
  background-color: #ffffff;
  border-color: var(--apple-sage);
  box-shadow: 0 0 0 4px rgba(45, 106, 79, 0.16);
}

.grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 0 1.25rem;
}

@media (max-width: 640px) {
  .grid { grid-template-columns: 1fr; }
  main { padding: 1.5rem 1rem 3rem; }
  .card { padding: 1.35rem; }
  h1 { font-size: 1.85rem; }
}

/* Apple Buttons with Tactile Spring Micro-interaction */
.btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  font-family: inherit;
  font-size: 0.92rem;
  font-weight: 600;
  letter-spacing: -0.01em;
  padding: 0.75rem 1.5rem;
  border-radius: var(--apple-radius-btn);
  border: 0;
  cursor: pointer;
  text-decoration: none;
  background: var(--apple-sage);
  color: #ffffff;
  box-shadow: 0 8px 18px rgba(154, 91, 63, 0.2);
  transition: transform 0.15s var(--ease-spring), background 0.15s var(--ease-spring), box-shadow 0.15s;
}

.btn:hover {
  background: var(--apple-sage-hover);
  color: #ffffff;
  box-shadow: 0 10px 22px rgba(154, 91, 63, 0.28);
}

.btn:active {
  transform: scale(0.975);
}

.btn.dark {
  background: #192a20;
  color: #ffffff;
  box-shadow: 0 2px 8px rgba(25, 42, 32, 0.18);
}

.btn.dark:hover {
  background: #233a2d;
}

.btn.red {
  background: rgba(217, 56, 58, 0.12);
  color: var(--apple-red);
  box-shadow: none;
}

.btn.red:hover {
  background: var(--apple-red);
  color: #ffffff;
}

.btn.ghost {
  background: transparent;
  color: var(--apple-text);
  border: 1px solid var(--apple-border-strong);
  box-shadow: none;
}

.btn.ghost:hover {
  background: rgba(154, 91, 63, 0.08);
  border-color: var(--apple-sage);
}

.btn.sm {
  padding: 0.42rem 0.9rem;
  font-size: 0.82rem;
  border-radius: 9999px;
}

/* Pastel Badges */
.badge {
  display: inline-flex;
  align-items: center;
  padding: 0.25rem 0.75rem;
  border-radius: 9999px;
  font-size: 0.78rem;
  font-weight: 600;
  letter-spacing: -0.01em;
  text-transform: capitalize;
}

.badge.confirmed, .badge.paid {
  background: var(--apple-pastel-mint);
  border: 1px solid var(--apple-pastel-mint-border);
  color: #1b533b;
}

.badge.cancelled, .badge.refunded {
  background: #fdeeee;
  border: 1px solid #f9cdce;
  color: #aa2729;
}

.badge.pending {
  background: #fef7e6;
  border: 1px solid #fae3af;
  color: #925800;
}

.badge.completed {
  background: #eef6f7;
  border: 1px solid #cbe4e6;
  color: #185a64;
}

/* Alert Notification Banner */
.flash {
  background: var(--apple-pastel-mint);
  border: 1px solid var(--apple-pastel-mint-border);
  color: #18533a;
  padding: 0.85rem 1.25rem;
  border-radius: 16px;
  font-weight: 600;
  font-size: 0.92rem;
  margin-bottom: 1.5rem;
  display: flex;
  align-items: center;
  gap: 0.65rem;
}

.err {
  color: var(--apple-red);
  font-size: 0.82rem;
  font-weight: 500;
  margin: 0.35rem 0 0;
}

/* Data Table Styling */
.tablewrap {
  overflow-x: auto;
  border-radius: var(--apple-radius-card);
}

table {
  width: 100%;
  border-collapse: separate;
  border-spacing: 0;
  font-size: 0.92rem;
}

th {
  background: #f7faf8;
  color: var(--apple-muted);
  font-size: 0.78rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.04em;
  padding: 0.9rem 1.1rem;
  border-bottom: 1px solid var(--apple-border);
  text-align: left;
}

td {
  padding: 1.05rem 1.1rem;
  border-bottom: 1px solid rgba(43, 84, 61, 0.06);
  vertical-align: middle;
  color: var(--apple-text);
}

tr:last-child td {
  border-bottom: none;
}

tr:hover td {
  background-color: rgba(154, 91, 63, 0.035);
}

form.inline { display: inline; }

.hero-visual {
  position: relative;
  overflow: hidden;
  border-radius: 28px;
  background: linear-gradient(135deg, #4b2d24 0%, #8b4f37 56%, #c58968 100%);
  color: #fffaf4;
  box-shadow: 0 24px 70px rgba(74, 48, 31, 0.2);
}

.hero-visual::after {
  content: "";
  position: absolute;
  width: 260px;
  height: 260px;
  right: -70px;
  top: -90px;
  border: 1px solid rgba(255,255,255,.25);
  border-radius: 50%;
  box-shadow: 0 0 0 28px rgba(255,255,255,.05), 0 0 0 56px rgba(255,255,255,.04);
}

.location-card {
  cursor: pointer;
}

.location-card:hover {
  transform: translateY(-5px);
}

@media (max-width: 640px) {
  header.top { align-items: flex-start; }
  nav { flex-wrap: wrap; justify-content: flex-end; gap: 0.15rem; }
  nav a { padding: 0.35rem 0.55rem; font-size: 0.78rem; }
}
</style>
</head>
<body>
<header class="top">
  <a class="brand" href="{{ route('home') }}">
    <span class="brand-dot"></span>
    <span>{{ config('restaurant.name') }}</span>
  </a>
  <nav>
    <a href="{{ route('home') }}">Reserve Table</a>
    @if(session('is_admin'))
      <a href="{{ route('admin.reservations.index') }}">Reservations</a>
      <a href="{{ route('admin.tables.index') }}">Tables</a>
      <form class="inline" method="POST" action="{{ route('admin.logout') }}">
        @csrf
        <button class="btn sm ghost" style="margin-left:0.5rem">Log out</button>
      </form>
    @else
      <a href="{{ route('admin.login') }}">Staff Access</a>
    @endif
  </nav>
</header>
<main>
  @if(session('ok'))
    <div class="flash">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
      {{ session('ok') }}
    </div>
  @endif
  @yield('content')
</main>
<footer style="border-top:1px solid var(--apple-border); padding:1.5rem 1.25rem 2.5rem; text-align:center; color:var(--apple-muted); font-size:.8rem;">
  <span>© {{ date('Y') }} {{ config('restaurant.name') }} · Crafted for memorable tables</span>
</footer>
</body>
</html>
