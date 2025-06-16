<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeLivewireCRUD extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:livewire-crud {name}';
    protected $description = 'Generate Livewire components for CRUD operations';

    /**
     * Execute the console command.
     */

    public function handle()
    {
        $name = $this->argument('name');

        $components = ['Index', 'Create', 'Edit'];

        foreach ($components as $component) {
            $className = "{$name}.{$component}";
            $this->call('make:livewire', ['name' => $className]);
            $this->info("Livewire component {$className} created.");
        }

        $this->info('CRUD components generated successfully!');
    }
}
