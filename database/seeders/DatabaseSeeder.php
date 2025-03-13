<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Module;
use App\Models\ModuleReading;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $modules =
        [
            ['name' => 'Temp Sensor 1', 'type' => 'Temperature', 'status' => 'Active'],
            ['name' => 'Speed Sensor 1', 'type' => 'Speed', 'status' => 'Active'],
            ['name' => 'Pressure Sensor', 'type' => 'Pressure', 'status' => 'Inactive'],
        ];

        foreach ($modules as $moduleData) {
            $module = Module::create($moduleData);

            // Generate initial random readings for the module
            ModuleReading::create([
                'module_id' => $module->id,
                'measured_value' => rand(10, 100), // Random value
                'status' => 'Active',
                'timestamp' => now(),
            ]);
        }

    }
}
