<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DiningTable;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $reservations = Reservation::with('table', 'payment')
            ->when($request->date, fn ($q, $d) => $q->whereDate('date', $d))
            ->when($request->q, fn ($q, $s) => $q->where(fn ($w) => $w->where('name', 'like', "%$s%")->orWhere('reference', 'like', "%$s%")))
            ->orderByDesc('date')->orderBy('time')->paginate(15)->withQueryString();
        return view('admin.reservations.index', compact('reservations'));
    }

    public function edit(Reservation $reservation)
    {
        $tables = DiningTable::orderBy('name')->get();
        return view('admin.reservations.edit', compact('reservation', 'tables'));
    }

    public function update(Request $request, Reservation $reservation)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100', 'email' => 'required|email', 'phone' => 'required|string|max:30',
            'restaurant' => 'required|string|in:' . implode(',', array_column(config('restaurant.locations'), 'name')),
            'dining_table_id' => 'required|exists:dining_tables,id',
            'date' => 'required|date', 'time' => 'required|in:' . implode(',', config('restaurant.slots')),
            'guests' => 'required|integer|min:1|max:12', 'notes' => 'nullable|string|max:500',
            'status' => 'required|in:confirmed,completed,cancelled',
        ]);

        $error = null;
        DB::transaction(function () use ($data, $reservation, &$error) {
            if ($data['status'] !== 'cancelled'
                && Reservation::conflicts($data['dining_table_id'], $data['date'], $data['time'], $reservation->id)) {
                $error = 'That table is already booked around that time.';
                return;
            }
            $reservation->update($data);
            // Cancelling refunds a paid deposit in the same transaction.
            if ($data['status'] === 'cancelled' && $reservation->payment?->status === 'paid') {
                $reservation->payment->update(['status' => 'refunded']);
            }
        });

        if ($error) return back()->withInput()->withErrors(['time' => $error]);
        return redirect()->route('admin.reservations.index')->with('ok', 'Reservation updated.');
    }

    public function destroy(Reservation $reservation)
    {
        DB::transaction(fn () => $reservation->delete()); // payment rows cascade
        return back()->with('ok', 'Reservation deleted.');
    }
}
