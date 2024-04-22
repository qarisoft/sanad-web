<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use function Database\Factories\str_rand;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('task_statuses', function (Blueprint $table) {
            $table->id();

            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->string('color')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_statuses');
    }
};
