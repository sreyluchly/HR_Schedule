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
     Schema::create('shifts', function (Blueprint $table) {
    $table->id();
    $table->string('employee_id');       
    $table->string('posted_by');         
    $table->date('shift_date');         
    
    // បន្ថែមវេនដើម និងវេនថ្មីដែលចង់ប្ដូរ
    $table->string('original_shift');    // វេនការងារបច្ចុប្បន្ន (ឧ. 7:00 AM - 4:00 PM)
    $table->string('new_shift');         // វេនការងារដែលចង់បាន (ឧ. 8:00 AM - 5:00 PM)
    
    $table->string('claimed_by')->nullable(); 
    $table->string('status')->default('pending'); 
    $table->timestamps(); 
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shifts');
    }
};