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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('category')->default('Lainnya');
            $table->string('condition')->default('Bekas Layak Pakai');
            $table->string('condition_note')->nullable();
            $table->text('description');
            $table->enum('mode', ['gratis', 'harga_pas', 'barter'])->index();
            $table->unsignedInteger('price')->nullable();
            $table->string('barter_request')->nullable();
            $table->text('contact_info');
            $table->string('meetup_location')->nullable();
            $table->string('time_handover')->nullable();
            $table->enum('status', ['available', 'locked'])->default('available')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
