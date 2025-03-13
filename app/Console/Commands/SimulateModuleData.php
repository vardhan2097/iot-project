<?php

namespace App\Console\Commands;

use App\Models\Module;
use App\Models\ModuleReading;
use Illuminate\Console\Command;

class SimulateModuleData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'simulate:modules';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Simulate Module Data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $modules = Module::all();
        foreach($modules as $module)
        {
            $status = (rand(0, 10) > 8) ? 'Malfunction' : 'Active';
            $value = rand(20, 100);

            $module->update(['status' => $status]);

            ModuleReading::create([
                'module_id' => $module->id,
                'measured_value' => $value,
                'status' => $status,
            ]);
        }
        $this->info('Module readings generated successfully!');
    }
}
