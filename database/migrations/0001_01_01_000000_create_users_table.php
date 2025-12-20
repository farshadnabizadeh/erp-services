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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            
            // Custom Fields based on your design
            $table->string('username')->unique();
            $table->string('mobile_number', 20)->unique();
            $table->string('password');
            
            // Standard Laravel fields
            $table->rememberToken();
            $table->timestamps();
        });

        // These tables are standard and usually needed, kept as is.
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            // Changed from email to username or mobile based on your preference
            // Assuming reset via mobile/username
            $table->string('mobile_number')->primary(); 
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
