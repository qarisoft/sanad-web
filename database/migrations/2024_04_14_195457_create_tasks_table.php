<?php

use App\Models\Company;
use App\Models\Customer;
use App\Models\Location;
use App\Models\TaskStatus;
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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            // $table->string('lat')->nullable();/
            // $table->string('lng')->nullable();
            $table->string('code');
            $table->string('notes')->nullable();

            $table->boolean('is_published')->default(false);

            $table->foreignIdFor(Company::class)->nullable();
            $table->foreignIdFor(Location::class)->nullable();
            $table->foreignIdFor(Customer::class)->nullable();
            $table->foreignIdFor(TaskStatus::class)->nullable();


            $table->timestamp('received_at')->nullable();
            $table->timestamp('must_do_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
