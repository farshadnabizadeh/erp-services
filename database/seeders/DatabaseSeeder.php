<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\SystemModule;
use App\Models\UserModule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create the User
        // We use firstOrCreate to avoid errors if you run seed multiple times without refreshing
        $user = User::firstOrCreate(
            ['username' => 'testuser'],
            [
                'mobile_number' => '09123456789',
                'password' => 'password', // Will be automatically hashed by the model's cast
            ]
        );

        // 2. Create System Modules (The Catalog/Blueprint)

        // Type A: A Folder (Container) - No configuration needed
        $sysFolder = SystemModule::firstOrCreate(
            ['slug' => 'folder-container'],
            [
                'name' => 'Folder',
                'default_config' => null,
            ]
        );

        // Type B: A Chart Component - Has default configuration
        $sysChart = SystemModule::firstOrCreate(
            ['slug' => 'widget-sales-chart'],
            [
                'name' => 'Sales Chart Widget',
                'default_config' => [
                    'chart_type' => 'line',
                    'color' => 'blue',
                    'refresh_interval' => 30,
                    'show_legend' => true
                ],
            ]
        );

        // Type C: A Clock Component
        $sysClock = SystemModule::firstOrCreate(
            ['slug' => 'widget-clock'],
            [
                'name' => 'Digital Clock',
                'default_config' => [
                    'format' => '24h',
                    'timezone' => 'UTC'
                ],
            ]
        );

        // 3. Create User Modules (The Tree Structure)

        // Root Node: "My Dashboard" (Using the Folder System Module)
        $dashboard = UserModule::firstOrCreate(
            [
                'user_id' => $user->id,
                'custom_name' => 'My Dashboard',
                'parent_id' => null,
            ],
            [
                'system_module_id' => $sysFolder->id,
                'sort_order' => 1,
                'settings' => null
            ]
        );

        // Child 1: "Revenue 2024" (Inside Dashboard) - With Custom Config
        UserModule::firstOrCreate(
            [
                'user_id' => $user->id,
                'custom_name' => 'Revenue 2024',
                'parent_id' => $dashboard->id,
            ],
            [
                'system_module_id' => $sysChart->id,
                'sort_order' => 1,
                'settings' => [
                    'color' => 'green', // Overriding default 'blue'
                    'chart_type' => 'bar' // Overriding default 'line'
                ]
            ]
        );

        // Child 2: "Traffic Stats" (Inside Dashboard) - Using Default Config
        UserModule::firstOrCreate(
            [
                'user_id' => $user->id,
                'custom_name' => 'Traffic Stats',
                'parent_id' => $dashboard->id,
            ],
            [
                'system_module_id' => $sysChart->id,
                'sort_order' => 2,
                'settings' => [] // Empty array means use all defaults
            ]
        );

        // Root Node 2: "Utilities" (Another Folder at root level)
        $utils = UserModule::firstOrCreate(
            [
                'user_id' => $user->id,
                'custom_name' => 'Utilities',
                'parent_id' => null,
            ],
            [
                'system_module_id' => $sysFolder->id,
                'sort_order' => 2,
                'settings' => null
            ]
        );

        // Child of Utilities: Clock
        UserModule::firstOrCreate(
            [
                'user_id' => $user->id,
                'custom_name' => 'Digital Clock',
                'parent_id' => $utils->id,
            ],
            [
                'system_module_id' => $sysClock->id,
                'sort_order' => 1,
                'settings' => [
                    'timezone' => 'Asia/Tehran'
                ]
            ]
        );
    }
}
