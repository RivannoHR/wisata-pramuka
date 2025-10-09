<?php
/*
 * Migration Runner for cPanel
 * Run this file once to execute all pending migrations
 */

// Set the working directory to the Laravel project root
chdir(__DIR__);

// Check if artisan file exists
if (!file_exists('artisan')) {
    die('Error: artisan file not found. Make sure this script is in the Laravel root directory.');
}

echo "Starting migration process...\n";

// Run the migration command
$output = [];
$return_var = 0;

exec('php artisan migrate --force 2>&1', $output, $return_var);

// Display output
echo "Migration Output:\n";
foreach ($output as $line) {
    echo $line . "\n";
}

if ($return_var === 0) {
    echo "\n✅ Migrations completed successfully!\n";
} else {
    echo "\n❌ Migration failed with exit code: $return_var\n";
}

echo "Migration process finished.\n";
?>
