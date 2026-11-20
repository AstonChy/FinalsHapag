<?php
namespace Database\Seeders;
use App\Models\DiningTable;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([['Window 1',2],['Window 2',2],['Garden 1',4],['Garden 2',4],['Family 1',6],['Family 2',8],['Private Room',12]] as [$n,$c]) {
            DiningTable::firstOrCreate(['name' => $n], ['capacity' => $c]);
        }
    }
}
