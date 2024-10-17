<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subscription_changes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\Subscription::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(App\Models\Plan::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(App\Models\User::class)->constrained()->cascadeOnDelete();
            $table->integer('new_users_count');
            $table->unsignedTinyInteger('new_billing_period');
            $table->double('total_price');
            $table->double('discount')->default(0);
            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_changes');
    }
};
