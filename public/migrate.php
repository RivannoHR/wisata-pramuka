<!DOCTYPE html>
<html>
<head>
    <title>Laravel Migration Runner</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .container { max-width: 800px; margin: 0 auto; }
        .output { background: #f4f4f4; padding: 20px; border-radius: 5px; margin: 20px 0; }
        .success { color: green; }
        .error { color: red; }
        .btn { background: #007cba; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Laravel Migration Runner</h1>
        
        <?php if (isset($_POST['run_migrations'])): ?>
            <div class="output">
                <?php
                // Change to Laravel root directory
                chdir('../');
                
                echo "<h3>Running Migrations...</h3>";
                
                // Execute migration command
                $command = 'php artisan migrate --force 2>&1';
                $output = shell_exec($command);
                
                echo "<pre>" . htmlspecialchars($output) . "</pre>";
                
                // Check if migration was successful
                if (strpos($output, 'Migrated:') !== false || strpos($output, 'Nothing to migrate') !== false) {
                    echo '<p class="success">✅ Migrations completed successfully!</p>';
                } else {
                    echo '<p class="error">❌ Migration may have failed. Check the output above.</p>';
                }
                ?>
            </div>
        <?php endif; ?>
        
        <form method="post">
            <button type="submit" name="run_migrations" class="btn">Run Migrations</button>
        </form>
        
        <h3>Available Migrations:</h3>
        <div class="output">
            <?php
            chdir('../database/migrations/');
            $migrations = glob('*.php');
            foreach ($migrations as $migration) {
                echo htmlspecialchars($migration) . "<br>";
            }
            ?>
        </div>
        
        <p><strong>⚠️ Security Note:</strong> Delete this file after use!</p>
    </div>
</body>
</html>
