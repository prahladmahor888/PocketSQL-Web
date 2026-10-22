<?php
// PocketSQL Hostinger Database Migration & Seeder Runner
ini_set('display_errors', 1);
ini_set('max_execution_time', 300);
error_reporting(E_ALL);

header('Content-Type: text/plain');

echo "=============================================\n";
echo "   PocketSQL Hostinger Database Migrator     \n";
echo "=============================================\n\n";

try {
    require __DIR__ . '/../vendor/autoload.php';
    $app = require_once __DIR__ . '/../bootstrap/app.php';

    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    $response = $kernel->handle(
        $request = Illuminate\Http\Request::capture()
    );

    echo "1. Checking Database Connection...\n";
    $driver = Illuminate\Support\Facades\DB::connection()->getDriverName();
    $database = Illuminate\Support\Facades\DB::connection()->getDatabaseName();
    echo "Driver: {$driver}\n";
    echo "Database: {$database}\n\n";

    echo "2. Running Migrations (php artisan migrate --force)...\n";
    Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
    echo Illuminate\Support\Facades\Artisan::output() . "\n";

    echo "3. Seeding Database (php artisan db:seed --force)...\n";
    Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
    echo Illuminate\Support\Facades\Artisan::output() . "\n";

    echo "4. Clearing and rebuilding application cache...\n";
    Illuminate\Support\Facades\Artisan::call('optimize:clear');
    echo Illuminate\Support\Facades\Artisan::output() . "\n";

    echo "=============================================\n";
    echo " SUCCESS: All tables migrated & seeded!     \n";
    echo "=============================================\n";
} catch (\Throwable $e) {
    echo "=============================================\n";
    echo " ERROR OCCURRED:                             \n";
    echo "=============================================\n";
    echo $e->getMessage() . "\n\n";
    echo $e->getTraceAsString() . "\n";
}
