<?php

namespace zhrnnsw\ProjectSetup\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Controller;
use Symfony\Component\Console\Output\BufferedOutput;
use zhrnnsw\ProjectSetup\Services\EnvironmentManager;

class SetupController extends Controller
{
    public function index()
    {
        return view('projectsetup::setup');
    }

    public function runSetup(Request $request)
    {
        $validate = $request->validate([
            'db_connection' => 'required|string',
            'db_host' => 'nullable|string',
            'db_port' => 'required|numeric',
            'db_database' => 'required|string',
            'db_username' => 'required|string',
            'db_password' => 'nullable|string',
        ]);


        $output = new BufferedOutput(); // Tangkap output dari Artisan

        try {
            Artisan::call('setup:project', [], $output); // Jalankan perintah
            $result = $output->fetch(); // Ambil output dari Artisan

            // Format output untuk tampilan HTML
            $formattedOutput = nl2br(e($result));
            $envUpdated = EnvironmentManager::updateEnv($validate); // Update file .env

            return response()->json([
                'status' => 'success',
                'message' => 'Project setup completed successfully!',
                'output' => $formattedOutput
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Setup failed!',
                'output' => nl2br(e($e->getMessage()))
            ]);
        }
    }
}
