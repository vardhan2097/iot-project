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
    protected $signature = 'simulate:module-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Simulate module data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $modules = Module::all();

        foreach($modules as $module)
        {
            if(rand(1,100) > 90)
            {
                $module->status = !$module->status;
                $module->save();
            }

            if($module->status)
            {
                ModuleReading::create([
                    'module_id' => $module->id,
                    'measured_value' => rand(20,100)/10,
                ]);
            }
        }
        $this->info('Module data simulated.');
    }
}