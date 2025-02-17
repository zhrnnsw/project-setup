<?php
namespace zhrnnsw\ProjectSetup\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class SetupProject extends Command
{
    protected $signature = 'setup:project';
    protected $description = 'Automate Laravel project setup';

    public function handle()
    {
        $this->info('Starting project setup...');
        // Run migrations
        Artisan::call('migrate');
        $this->info('Database migrations completed.');

        // Create storage symlink
        if (!File::exists(public_path('storage'))) {
            Artisan::call('storage:link');
            $this->info('Storage symlink created.');
        } else {
            $this->info('Storage symlink already exists.');
        }

        // Check .env file
        if (!File::exists(base_path('.env'))) {
            File::copy(base_path('.env.example'), base_path('.env'));    
            Artisan::call('key:generate');
            $this->info('.env file created and app key generated.');
        } else {
            $this->info('.env file already exists.');
        }

        $this->info('Project setup completed successfully!');
    }
}
