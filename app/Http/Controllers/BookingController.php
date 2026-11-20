<?php
namespace App\Http\Controllers;

use App\Mail\ReservationConfirmed;
use App\Models\DiningTable;
use App\Models\Payment;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function home()
    {
        return view('home', ['locations' => config('restaurant.locations')]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'   => 'required|string|max:100',
            'email'  => 'required|email|max:150',
            'phone'  => 'required|string|max:30',
            'restaurant' => 'required|string|in:' . implode(',', array_column(config('restaurant.locations'), 'name')),
            'date'   => 'required|date|after_or_equal:today',
            'time'   => 'required|in:' . implode(',', config('restaurant.slots')),
            'guests' => 'required|integer|min:1|max:12',
            'notes'  => 'nullable|string|max:500',
            'method' => 'required|in:gcash,card,cash',
        ]);

        try {
            // TRANSACTION: table assignment + reservation + payment succeed or fail together.
            $reservation = DB::transaction(function () use ($data) {
                $tables = DiningTable::where('is_active', true)
                    ->where('capacity', '>=', $data['guests'])
                    ->orderBy('capacity')
                    ->lockForUpdate()
                    ->get();

                foreach ($tables as $table) {
                    if (Reservation::conflicts($table->id, $data['date'], $data['time'])) continue;

                    $reservation = Reservation::create([
                        'reference' => 'RSV-' . strtoupper(Str::random(8)),
                        'name' => $data['name'], 'email' => $data['email'], 'phone' => $data['phone'],
                        'restaurant' => $data['restaurant'],
                        'dining_table_id' => $table->id,
                        'date' => $data['date'], 'time' => $data['time'],
                        'guests' => $data['guests'], 'notes' => $data['notes'] ?? null,
                        'status' => 'confirmed',
                    ]);

                    Payment::create([
                        'reservation_id' => $reservation->id,
                        'amount' => config('restaurant.deposit_per_guest') * $data['guests'],
                        'method' => $data['method'],
                        'status' => $data['method'] === 'cash' ? 'pending' : 'paid', // simulated gateway
                        'transaction_ref' => 'TXN-' . strtoupper(Str::random(10)),
                    ]);

                    return $reservation;
                }
                throw new \RuntimeException('No table available');
            });
        } catch (\RuntimeException $e) {
            return back()->withInput()->withErrors(['time' => 'Sorry, no table is free for that date, time and party size. Try another slot.']);
        }

        // Email is sent after the transaction commits; a mail failure never cancels the booking.
        try {
            Mail::to($reservation->email)->send(new ReservationConfirmed($reservation->load('table', 'payment')));
        } catch (\Throwable $e) {
            report($e);
        }

        return redirect()->route('booking.show', $reservation->reference);
    }

    public function show(string $reference)
    {
        $reservation = Reservation::with('table', 'payment')->where('reference', $reference)->firstOrFail();
        return view('booking-show', compact('reservation'));
    }
}
