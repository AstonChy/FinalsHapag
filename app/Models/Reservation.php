<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = ['reference','name','email','phone','restaurant','dining_table_id','date','time','guests','notes','status'];
    protected $casts = ['date' => 'date'];

    public function table() { return $this->belongsTo(DiningTable::class, 'dining_table_id'); }
    public function payment() { return $this->hasOne(Payment::class); }

    public static function minutes(string $t): int
    {
        [$h, $m] = explode(':', substr($t, 0, 5));
        return $h * 60 + $m;
    }

    /** True if the table is already held within the duration window. */
    public static function conflicts(int $tableId, string $date, string $time, ?int $ignoreId = null): bool
    {
        $start = self::minutes($time);
        return self::where('dining_table_id', $tableId)
            ->whereDate('date', $date)
            ->where('status', '!=', 'cancelled')
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->get()
            ->contains(fn ($r) => abs(self::minutes($r->time) - $start) < config('restaurant.duration'));
    }
}
