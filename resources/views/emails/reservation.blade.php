<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
body { margin: 0; padding: 24px; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; background-color: #f2f7f4; color: #192a20; }
.card { max-width: 520px; margin: 0 auto; background: #ffffff; border-radius: 20px; border: 1px solid rgba(43, 84, 61, 0.12); padding: 32px; box-shadow: 0 4px 24px rgba(27, 56, 38, 0.05); }
h2 { font-size: 22px; font-weight: 700; margin: 0 0 8px; color: #192a20; letter-spacing: -0.02em; }
p { font-size: 15px; line-height: 1.5; color: #405548; margin: 0 0 16px; }
.receipt-box { background: #e8f4ed; border-radius: 14px; border: 1px solid #c8e3d3; padding: 18px 20px; margin: 20px 0; }
.receipt-row { display: flex; justify-content: space-between; padding: 6px 0; font-size: 14px; border-bottom: 1px solid #d9ebe0; }
.receipt-row:last-child { border-bottom: none; }
.label { color: #5e7468; }
.val { font-weight: 600; color: #192a20; }
.btn { display: inline-block; background: #2d6a4f; color: #ffffff !important; text-decoration: none; padding: 12px 26px; border-radius: 9999px; font-weight: 600; font-size: 14px; margin-top: 12px; box-shadow: 0 2px 8px rgba(45, 106, 79, 0.25); }
</style>
</head>
<body>
<div class="card">
  <h2>Table Confirmed at {{ $reservation->restaurant }}</h2>
  <p>Hi {{ $reservation->name }},</p>
  <p>Your table reservation has been successfully confirmed. Here is your receipt summary:</p>

  <div class="receipt-box">
    <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
      <tr><td style="padding: 6px 0; color: #5e7468;">Reference</td><td style="padding: 6px 0; text-align: right; font-weight: 600; font-family: monospace;">{{ $reservation->reference }}</td></tr>
      <tr><td style="padding: 6px 0; color: #5e7468;">Restaurant</td><td style="padding: 6px 0; text-align: right; font-weight: 600;">{{ $reservation->restaurant }}</td></tr>
      <tr><td style="padding: 6px 0; color: #5e7468;">Date & Time</td><td style="padding: 6px 0; text-align: right; font-weight: 600;">{{ $reservation->date->format('l, F j, Y') }} at {{ date('g:i A', strtotime($reservation->time)) }}</td></tr>
      <tr><td style="padding: 6px 0; color: #5e7468;">Guests</td><td style="padding: 6px 0; text-align: right; font-weight: 600;">{{ $reservation->guests }} Guest{{ $reservation->guests > 1 ? 's' : '' }}</td></tr>
      <tr><td style="padding: 6px 0; color: #5e7468;">Assigned Table</td><td style="padding: 6px 0; text-align: right; font-weight: 600;">{{ $reservation->table->name }}</td></tr>
      <tr><td style="padding: 6px 0; color: #5e7468;">Deposit ({{ ucfirst($reservation->payment->status) }})</td><td style="padding: 6px 0; text-align: right; font-weight: 600;">₱{{ number_format($reservation->payment->amount, 2) }}</td></tr>
      <tr><td style="padding: 6px 0; color: #5e7468;">Transaction ID</td><td style="padding: 6px 0; text-align: right; font-weight: 600; font-family: monospace;">{{ $reservation->payment->transaction_ref }}</td></tr>
    </table>
  </div>

  <div style="text-align: center; margin-top: 24px;">
    <a href="{{ route('booking.show', $reservation->reference) }}" class="btn">View Reservation Online</a>
  </div>

  <p style="font-size: 13px; color: #5e7468; text-align: center; margin-top: 24px;">
    We look forward to serving you at {{ $reservation->restaurant }}.
  </p>
</div>
</body>
</html>
