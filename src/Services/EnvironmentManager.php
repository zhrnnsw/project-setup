<?php
namespace zhrnnsw\ProjectSetup\Services;

use Illuminate\Support\Facades\File;

class EnvironmentManager
{
    public static function updateEnv(array $data)
    {
        $envPath = base_path('.env');
        if (!File::exists($envPath)) {
            return false;
        }

        $envContent = File::get($envPath);
        foreach ($data as $key => $value) {
            $envContent = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $envContent);
        }

        File::put($envPath, $envContent);
        return true;
    }
}
