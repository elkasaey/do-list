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
        Schema::create('dolists', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('desc');
            $table->foreignId('status_id')->references('id')->on('statuses')->defaults('1')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dolists');
    }
};
