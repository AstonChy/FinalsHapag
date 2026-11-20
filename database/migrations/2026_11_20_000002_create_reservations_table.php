<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $t) {
            $t->id();
            $t->string('reference')->unique();
            $t->string('name');
            $t->string('email');
            $t->string('phone');
            $t->foreignId('dining_table_id')->constrained('dining_tables');
            $t->date('date');
            $t->string('time', 5);
            $t->unsignedTinyInteger('guests');
            $t->text('notes')->nullable();
            $t->string('status')->default('confirmed'); // confirmed | completed | cancelled
            $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('reservations'); }
};
