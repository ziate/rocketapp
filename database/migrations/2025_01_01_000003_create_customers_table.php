<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->text('address');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('area_customer', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('area_id')->constrained()->cascadeOnDelete();
            $table->decimal('custom_delivery_price', 10, 2)->nullable();
            $table->timestamps();
            $table->unique(['customer_id', 'area_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('area_customer');
        Schema::dropIfExists('customers');
    }
};
