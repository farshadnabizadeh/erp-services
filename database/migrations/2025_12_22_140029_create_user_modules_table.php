<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_modules', function (Blueprint $table) {
            $table->id();

            // -----------------------------------------------------------------
            // Core Relationships
            // -----------------------------------------------------------------

            // The owner of this module instance
            $table->unsignedBigInteger('user_id');

            // Reference to the system catalog.
            // It is nullable because a user might create a generic folder/group
            // (e.g., "My Stuff") that contains other modules but isn't a module itself.
            $table->unsignedBigInteger('system_module_id')->nullable();

            // Self-referencing ID for the tree structure (Adjacency List)
            $table->unsignedBigInteger('parent_id')->nullable();

            // -----------------------------------------------------------------
            // Configuration & Display
            // -----------------------------------------------------------------

            // The name the user sees. The user can rename 'Accounting' to 'Financials'.
            $table->string('custom_name');

            // Stores specific configuration for this user instance.
            // Overrides the 'default_config' from system_modules.
            // Example: {"theme": "dark", "features": {"tax": false}}
            $table->json('settings')->nullable();

            // Order of the item in the sidebar/menu (e.g., 1, 2, 3)
            $table->integer('sort_order')->default(0);

            // Allows the user to temporarily disable the module without deleting data
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            // -----------------------------------------------------------------
            // Foreign Keys
            // -----------------------------------------------------------------

            // If the user is deleted, delete all their modules
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            // If a system module is deleted, we restrict it to prevent data loss,
            // or use 'set null' if you want to keep the user's record.
            $table->foreign('system_module_id')
                ->references('id')
                ->on('system_modules')
                ->onDelete('restrict');

            // If a parent folder is deleted, delete all children (Cascade delete for tree)
            $table->foreign('parent_id')
                ->references('id')
                ->on('user_modules')
                ->onDelete('cascade');

            // -----------------------------------------------------------------
            // Indexes
            // -----------------------------------------------------------------

            // Composite index for fast retrieval of a user's menu tree
            $table->index(['user_id', 'parent_id', 'sort_order']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_modules');
    }
};
