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
        Schema::create('jobs', function (Blueprint $table) {
    $table->id();
    
    // Employer reference
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    
    // Job details
    $table->string('title');
    $table->string('category')->nullable();
    $table->text('description')->nullable();
    $table->string('location')->nullable(); // New: location
    
    // Skills as JSON array
    $table->json('skills')->nullable(); // Stores skills like ["PHP","Laravel","Tailwind"]
    
    // Salary range
    $table->integer('salary_min')->nullable();
    $table->integer('salary_max')->nullable();
    
    // Status
    $table->boolean('is_active')->default(true);
    
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
