<?php

use App\Models\Company;
use App\Models\Customer;
use App\Models\Map\Polygon;
use App\Models\Role;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('avatar_url')->nullable();
            $table->foreignId('owner_id')->nullable();
            $table->timestamps();
        });
        Schema::create('followers', function (Blueprint $table) {
            $table->primary(['company_id', 'follower_id', 'follower_type']);
            $table->morphs('follower');
            $table->foreignIdFor(Company::class); //->constrained()->cascadeOnDelete();
        });
        Schema::create('company_polygon', function (Blueprint $table) {
            $table->primary(['company_id', 'polygon_id']);
            $table->foreignIdFor(Company::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Polygon::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
        Schema::create('company_user', function (Blueprint $table) {
            $table->primary(['company_id', 'user_id']);
            $table->foreignIdFor(Company::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
        Schema::create('company_customer', function (Blueprint $table) {
            $table->primary(['company_id', 'customer_id']);
            $table->foreignIdFor(Company::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Customer::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
        Schema::create('company_task', function (Blueprint $table) {
            $table->primary(['company_id', 'task_id']);
            $table->foreignIdFor(Company::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Task::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
        Schema::create('company_role', function (Blueprint $table) {
            $table->primary(['company_id', 'role_id']);
            $table->foreignIdFor(Company::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Role::class)->constrained()->cascadeOnDelete();

            $table->timestamps();
        });
        Schema::create('company_task_status', function (Blueprint $table) {
            $table->primary(['company_id', 'task_status_id']);
            $table->foreignIdFor(Company::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(TaskStatus::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
        Schema::dropIfExists('company_customer');
        Schema::dropIfExists('company_task');
        Schema::dropIfExists('company_role');
        Schema::dropIfExists('company_task_status');
    }
};
