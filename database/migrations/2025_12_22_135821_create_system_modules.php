<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('system_modules', function (Blueprint $table) {
            $table->id();

            // Unique identifier for the module logic (e.g., 'accounting', 'inventory', 'crm')
            $table->string('slug')->unique();

            // Display name for the module (e.g., 'Accounting System')
            $table->string('name');

            // Default configuration schema (JSON).
            // This defines what settings represent the default state of the module.
            // Example: {"theme": "light", "features": {"tax": true}}
            $table->json('default_config')->nullable();

            // Description shown in the module marketplace/selection screen
            $table->text('description')->nullable();

            // Toggle to globally enable or disable a module in the system
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('system_modules');
    }
};
