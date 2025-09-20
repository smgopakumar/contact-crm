<?php

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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->enum('source_type', ['lead', 'account', 'other']);
            $table->unsignedBigInteger('source_id')->nullable(); // FK to lead/account etc.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
