<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Module::create(['name' => 'Temperature Sensor 1', 'type' => 'Temperature']);
        Module::create(['name' => 'Speed Sensor 1', 'type' => 'Speed']);
    }
}
