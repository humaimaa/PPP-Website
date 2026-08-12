<?php
// verify_fix.php - Complete Server Verification (Windows Compatible)
// Place this in: public/verify_fix.php

echo "========================================\n";
echo "  COMPLETE SERVER VERIFICATION\n";
echo "  PPP WEBSITE - PRODUCTION CHECK\n";
echo "========================================\n\n";

$allPassed = true;
$issues = [];
$warnings = [];

// ============================================
// DETECT ROOT PATH (Since we're in public folder)
// ============================================
$rootPath = dirname(__DIR__); // Go up one level from public
echo "Root Path: " . $rootPath . "\n\n";

// ============================================
// 1. PHP VERSION CHECK
// ============================================
echo "1. PHP VERSION:\n";
echo "   Current: " . phpversion() . "\n";
if (version_compare(phpversion(), '8.0', '>=')) {
    echo "   Status: ✅ OK (PHP 8.0+)\n";
} else {
    echo "   Status: ❌ NEEDS UPGRADE (PHP 8.0+ required)\n";
    $issues[] = "PHP version " . phpversion() . " (need 8.0+)";
    $allPassed = false;
}
echo "\n";

// ============================================
// 2. REQUIRED PHP EXTENSIONS
// ============================================
echo "2. PHP EXTENSIONS:\n";

$extensions = [
    'gd' => 'Image processing (REQUIRED for projects)',
    'fileinfo' => 'File validation (REQUIRED for uploads)',
    'pdo_mysql' => 'Database connection (REQUIRED)',
    'mbstring' => 'String handling (REQUIRED)',
    'exif' => 'Image metadata (RECOMMENDED)',
    'json' => 'JSON support (REQUIRED)',
    'openssl' => 'Security (REQUIRED)',
    'curl' => 'HTTP requests (RECOMMENDED)',
];

$missingExtensions = [];
foreach ($extensions as $ext => $desc) {
    $loaded = extension_loaded($ext);
    $status = $loaded ? "✅ ENABLED" : "❌ MISSING";
    echo "   $ext: $status\n";
    echo "      → $desc\n";
    if (!$loaded) {
        $missingExtensions[] = $ext;
        $allPassed = false;
    }
}

if (!empty($missingExtensions)) {
    $issues[] = "Missing extensions: " . implode(', ', $missingExtensions);
    echo "\n   ⚠️ To fix, add these to MultiPHP INI Editor:\n";
    foreach ($missingExtensions as $ext) {
        echo "      extension=$ext\n";
    }
}
echo "\n";

// ============================================
// 3. FILE PERMISSIONS (Using root path)
// ============================================
echo "3. FILE PERMISSIONS:\n";

$paths = [
    'storage' => $rootPath . '/storage',
    'storage/app/public' => $rootPath . '/storage/app/public',
    'storage/app/public/projects' => $rootPath . '/storage/app/public/projects',
    'storage/app/public/tenders' => $rootPath . '/storage/app/public/tenders',
    'bootstrap/cache' => $rootPath . '/bootstrap/cache',
    'public/storage' => __DIR__ . '/storage', // public/storage
    '.env' => $rootPath . '/.env', // .env is in root, not public
];

foreach ($paths as $name => $path) {
    $exists = file_exists($path);
    $writable = $exists ? is_writable($path) : false;
    $isLink = is_link($path);
    
    echo "   $name:\n";
    echo "      Path: $path\n";
    echo "      Exists: " . ($exists ? "✅" : "❌") . "\n";
    if ($exists) {
        echo "      Writable: " . ($writable ? "✅" : "❌") . "\n";
        if ($isLink) {
            echo "      Link: ✅ -> " . readlink($path) . "\n";
        }
    } else {
        if ($name == 'storage/app/public/projects' || $name == 'storage/app/public/tenders') {
            echo "      ⚠️ Creating directory...\n";
            if (mkdir($path, 0755, true)) {
                echo "      ✅ Created successfully\n";
            } else {
                echo "      ❌ Failed to create\n";
                $issues[] = "Could not create: $name";
            }
        } elseif ($name != '.env') {
            $issues[] = "Missing directory: $name";
            $allPassed = false;
        }
    }
}
echo "\n";

// ============================================
// 4. ENVIRONMENT FILE (.env) - IN ROOT
// ============================================
echo "4. ENVIRONMENT (.env):\n";
echo "   Looking for .env in: " . $rootPath . "/.env\n";

$envPath = $rootPath . '/.env';
if (file_exists($envPath)) {
    echo "   ✅ .env file exists\n";
    $env = file_get_contents($envPath);
    
    // Check required variables
    $envVars = [
        'APP_ENV' => 'production',
        'APP_DEBUG' => 'false',
        'APP_URL' => null,
        'DB_DATABASE' => null,
        'DB_USERNAME' => null,
        'DB_PASSWORD' => null,
    ];
    
    foreach ($envVars as $var => $expected) {
        preg_match('/^' . $var . '=(.*)$/m', $env, $matches);
        $value = trim($matches[1] ?? 'Not set');
        
        if ($var == 'APP_ENV' && $value != 'production') {
            echo "   ⚠️ $var: $value (should be 'production')\n";
            $warnings[] = "APP_ENV is '$value' (should be 'production')";
        } elseif ($var == 'APP_DEBUG' && $value != 'false') {
            echo "   ⚠️ $var: $value (should be 'false')\n";
            $warnings[] = "APP_DEBUG is '$value' (should be 'false' in production)";
        } else {
            echo "   $var: " . ($value != 'Not set' ? "✅ " . $value : "❌ Not set") . "\n";
            if ($value == 'Not set') {
                $issues[] = "$var not set in .env";
                $allPassed = false;
            }
        }
    }
    
    // Check database credentials specifically
    echo "\n   Database Credentials:\n";
    $dbVars = ['DB_HOST', 'DB_PORT', 'DB_DATABASE', 'DB_USERNAME'];
    foreach ($dbVars as $var) {
        preg_match('/^' . $var . '=(.*)$/m', $env, $matches);
        $value = trim($matches[1] ?? 'Not set');
        $status = $value != 'Not set' ? "✅" : "❌";
        echo "      $status $var: " . ($value != 'Not set' ? $value : 'MISSING') . "\n";
        if ($value == 'Not set') {
            $issues[] = "$var not set in .env";
            $allPassed = false;
        }
    }
} else {
    echo "   ❌ .env file MISSING!\n";
    echo "   ⚠️ Copy .env.example to .env in the root folder\n";
    $issues[] = ".env file missing";
    $allPassed = false;
}
echo "\n";

// ============================================
// 5. DATABASE CONNECTION
// ============================================
echo "5. DATABASE:\n";

try {
    // Bootstrap Laravel from root
    if (file_exists($rootPath . '/vendor/autoload.php') && file_exists($rootPath . '/bootstrap/app.php')) {
        require_once $rootPath . '/vendor/autoload.php';
        $app = require_once $rootPath . '/bootstrap/app.php';
        $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
        $kernel->bootstrap();
        
        $pdo = DB::connection()->getPdo();
        echo "   ✅ Connection successful\n";
        echo "   Database: " . DB::connection()->getDatabaseName() . "\n";
        
        // Check tables
        $tables = DB::select('SHOW TABLES');
        $tableNames = array_map('current', $tables);
        echo "   Tables found: " . count($tableNames) . "\n";
        
        $requiredTables = ['projects', 'tenders', 'sectors', 'users', 'migrations'];
        $missingTables = [];
        
        foreach ($requiredTables as $table) {
            $exists = in_array($table, $tableNames);
            echo "   " . ($exists ? "✅" : "❌") . " $table\n";
            if (!$exists) {
                $missingTables[] = $table;
            }
        }
        
        if (!empty($missingTables)) {
            $issues[] = "Missing tables: " . implode(', ', $missingTables);
            $allPassed = false;
            echo "\n   ⚠️ Run: php artisan migrate --force\n";
        }
        
        // Check project table structure if it exists
        if (in_array('projects', $tableNames)) {
            $columns = DB::select('DESCRIBE projects');
            $columnNames = array_map(function($col) { return $col->Field; }, $columns);
            
            $requiredColumns = ['id', 'name', 'sector_id', 'image', 'division', 'category', 'status', 'slug', 'publish'];
            $missingColumns = [];
            
            foreach ($requiredColumns as $col) {
                if (!in_array($col, $columnNames)) {
                    $missingColumns[] = $col;
                }
            }
            
            if (!empty($missingColumns)) {
                $issues[] = "Missing columns in projects table: " . implode(', ', $missingColumns);
                $allPassed = false;
                echo "\n   ⚠️ Missing columns: " . implode(', ', $missingColumns) . "\n";
                echo "   Run: php artisan migrate --force\n";
            } else {
                echo "\n   ✅ Project table structure is correct\n";
            }
            
            // Check if there are any projects
            $projectCount = DB::table('projects')->count();
            echo "   Projects in database: " . $projectCount . "\n";
        }
    } else {
        echo "   ❌ Laravel not bootstrapped\n";
        echo "   ⚠️ Run: composer install\n";
        $issues[] = "Laravel not properly installed";
        $allPassed = false;
    }
    
} catch (Exception $e) {
    echo "   ❌ Connection failed\n";
    echo "   Error: " . $e->getMessage() . "\n";
    $issues[] = "Database error: " . $e->getMessage();
    $allPassed = false;
}
echo "\n";

// ============================================
// 6. STORAGE LINK (WINDOWS COMPATIBLE)
// ============================================
echo "6. STORAGE LINK:\n";

$publicStorage = __DIR__ . '/storage';
$target = $rootPath . '/storage/app/public';
$isWorking = false;

if (file_exists($publicStorage)) {
    if (is_dir($publicStorage)) {
        // Test if it actually works by creating a test file
        $testFile = 'test_' . time() . '.txt';
        @file_put_contents($target . '/' . $testFile, 'Test content for junction verification');
        
        if (file_exists($publicStorage . '/' . $testFile)) {
            $isWorking = true;
            echo "   ✅ Storage link WORKS!\n";
            echo "   → " . $publicStorage . " → " . $target . "\n";
            @unlink($target . '/' . $testFile);
        } else {
            // Check if it's a junction using fsutil
            $attributes = @exec('fsutil reparsepoint query "' . $publicStorage . '" 2>&1');
            if (strpos($attributes, 'Reparse Tag Value') !== false) {
                $isWorking = true;
                echo "   ✅ Storage is a JUNCTION!\n";
                echo "   → " . $publicStorage . " → " . $target . "\n";
                echo "   ⚠️ Note: is_link() doesn't detect Windows junctions, but it works!\n";
            } else {
                echo "   ❌ Storage exists but is NOT a junction!\n";
                $issues[] = "Storage is a regular folder, not a junction";
                $allPassed = false;
            }
        }
    } else {
        echo "   ❌ Storage is not a directory\n";
        $issues[] = "Storage is not a directory";
        $allPassed = false;
    }
} else {
    echo "   ❌ Storage link MISSING!\n";
    echo "   ⚠️ Run: php artisan storage:link\n";
    $issues[] = "Storage link missing";
    $allPassed = false;
}
echo "\n";

// ============================================
// 7. FILE UPLOAD TEST
// ============================================
echo "7. FILE UPLOAD TEST:\n";

try {
    if (file_exists($rootPath . '/vendor/autoload.php') && file_exists($rootPath . '/bootstrap/app.php')) {
        require_once $rootPath . '/vendor/autoload.php';
        $app = require_once $rootPath . '/bootstrap/app.php';
        $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
        $kernel->bootstrap();
        
        $testFile = 'test_' . time() . '.txt';
        $result = Storage::disk('public')->put($testFile, 'Test content');
        
        if ($result) {
            echo "   ✅ Can write to storage\n";
            Storage::disk('public')->delete($testFile);
            echo "   ✅ Cleanup successful\n";
        } else {
            echo "   ❌ Cannot write to storage\n";
            $issues[] = "Cannot write to storage";
            $allPassed = false;
        }
    }
} catch (Exception $e) {
    echo "   ❌ Error: " . $e->getMessage() . "\n";
    $issues[] = "Storage test error: " . $e->getMessage();
    $allPassed = false;
}
echo "\n";

// ============================================
// 8. MIGRATION STATUS
// ============================================
echo "8. MIGRATION STATUS:\n";

try {
    if (file_exists($rootPath . '/vendor/autoload.php') && file_exists($rootPath . '/bootstrap/app.php')) {
        require_once $rootPath . '/vendor/autoload.php';
        $app = require_once $rootPath . '/bootstrap/app.php';
        $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
        $kernel->bootstrap();
        
        // Check if migrations table exists
        $tables = DB::select('SHOW TABLES');
        $tableNames = array_map('current', $tables);
        
        if (in_array('migrations', $tableNames)) {
            $migrationCount = DB::table('migrations')->count();
            echo "   ✅ Migrations table exists\n";
            echo "   → " . $migrationCount . " migrations recorded\n";
            
            if ($migrationCount == 0) {
                echo "   ⚠️ No migrations recorded\n";
                echo "   → Run: php artisan migrate --force\n";
                $warnings[] = "No migrations recorded";
            } else {
                // Show last few migrations
                $lastMigrations = DB::table('migrations')->orderBy('id', 'desc')->limit(3)->get();
                echo "   Last migrations:\n";
                foreach ($lastMigrations as $m) {
                    echo "      • " . $m->migration . " (batch: " . $m->batch . ")\n";
                }
            }
        } else {
            echo "   ❌ Migrations table missing\n";
            echo "   → Run: php artisan migrate --force\n";
            $issues[] = "Migrations table missing";
            $allPassed = false;
        }
    }
} catch (Exception $e) {
    echo "   ❌ Error: " . $e->getMessage() . "\n";
}
echo "\n";

// ============================================
// 9. SUMMARY
// ============================================
echo "========================================\n";
echo "  VERIFICATION SUMMARY\n";
echo "========================================\n\n";

if ($allPassed && empty($issues)) {
    echo "✅ ALL CHECKS PASSED!\n";
    echo "Your server is ready for the website.\n";
    echo "\nIf you still have issues:\n";
    echo "1. Clear cache: php artisan optimize:clear\n";
    echo "2. Cache config: php artisan config:cache\n";
    echo "3. Restart PHP service\n";
} else {
    echo "❌ ISSUES FOUND:\n\n";
    foreach ($issues as $index => $issue) {
        echo ($index + 1) . ". " . $issue . "\n";
    }
    
    if (!empty($warnings)) {
        echo "\n⚠️ WARNINGS:\n";
        foreach ($warnings as $index => $warning) {
            echo ($index + 1) . ". " . $warning . "\n";
        }
    }
    
    echo "\n📌 RECOMMENDED FIXES:\n";
    $fixCount = 1;
    
    if (!empty($missingExtensions)) {
        echo $fixCount . ". Enable missing extensions in MultiPHP INI Editor\n";
        $fixCount++;
    }
    if (strpos(implode(' ', $issues), 'storage link') !== false) {
        echo $fixCount . ". Run: php artisan storage:link\n";
        $fixCount++;
    }
    if (strpos(implode(' ', $issues), 'migrations') !== false || strpos(implode(' ', $issues), 'Missing tables') !== false) {
        echo $fixCount . ". Run: php artisan migrate --force\n";
        $fixCount++;
    }
    if (strpos(implode(' ', $issues), '.env') !== false) {
        echo $fixCount . ". Create .env file from .env.example in root folder\n";
        $fixCount++;
    }
    if (strpos(implode(' ', $issues), 'storage') !== false && strpos(implode(' ', $issues), 'writable') !== false) {
        echo $fixCount . ". Run: chmod -R 755 " . $rootPath . "/storage " . $rootPath . "/bootstrap/cache\n";
        $fixCount++;
    }
}

echo "\n========================================\n";
echo "  VERIFICATION COMPLETE\n";
echo "========================================\n";

// Show all loaded extensions for debugging
echo "\nAll loaded extensions:\n";
echo implode(', ', get_loaded_extensions()) . "\n";

// Show PHP Info summary
echo "\nPHP Configuration:\n";
echo "  upload_max_filesize: " . ini_get('upload_max_filesize') . "\n";
echo "  post_max_size: " . ini_get('post_max_size') . "\n";
echo "  memory_limit: " . ini_get('memory_limit') . "\n";
echo "  max_execution_time: " . ini_get('max_execution_time') . " seconds\n";
?>