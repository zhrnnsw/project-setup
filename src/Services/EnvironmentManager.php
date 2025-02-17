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

        // Mapping manual key ke format .env yang benar
        $keyMapping = [
            'db_port' => 'DB_PORT',
            'db_database' => 'DB_DATABASE',
            'db_username' => 'DB_USERNAME',
            'db_password' => 'DB_PASSWORD',
        ];

        $envContent = File::get($envPath);

        foreach ($data as $key => $value) {
            // Cek jika key ada dalam mapping, kalau tidak tambahkan manual
            if (isset($keyMapping[$key])) {
                $envKey = $keyMapping[$key];
                // Update atau tambah key jika sudah ada
                $envContent = preg_replace("/^{$envKey}=\s*.*/m", "{$envKey}={$value}", $envContent);
            } else {
                // Tambahkan key-value baru jika tidak ada dalam mapping
                $envContent .= "\n{$key}={$value}";
            }
        }

        File::put($envPath, $envContent);
        return true;
    }
}
