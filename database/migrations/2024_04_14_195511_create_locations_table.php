<?php

use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('place_id')->nullable();
//                ->default(DB::raw('(UUID())'));

            $table->string('lat', 32)->nullable();
            $table->string('lng', 32)->nullable();
            $table->string('street')->nullable();
            $table->string('city')->nullable();
            $table->string('type')->nullable();
            $table->string('state')->nullable();
            $table->string('zip')->nullable();
            $table->string('address', 1024)->nullable();
            $table->morphs('item');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
