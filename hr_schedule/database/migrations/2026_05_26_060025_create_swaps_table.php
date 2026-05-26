<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('swaps', function (Blueprint $table) {
            $table->id();
            $table->string('posted_by');
            $table->string('claimed_by');
            $table->string('shift_time');
            $table->string('approved_by')->default('HR_Admin');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('swaps');
    }
};
