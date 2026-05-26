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
        Schema::create('swaps', function (Blueprint $table) {
            $table->id();
            $table->string('posted_by');    // ឈ្មោះអ្នកផ្ដល់វេនឱ្យគេ
            $table->string('claimed_by');   // ឈ្មោះអ្នកមកទទួលធ្វើជំនួស
            $table->string('shift_time');   // ម៉ោងដែលបានប្ដូរ
            $table->string('approved_by')->default('HR_Admin'); // អ្នកអនុម័ត
            $table->timestamps();           // ថ្ងៃខែម៉ោងដែលបានប្ដូរជោគជ័យ
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('swaps');
    }
};
