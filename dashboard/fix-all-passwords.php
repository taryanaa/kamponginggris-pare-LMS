<?php
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Hash;

echo "<h2>🔐 Update All Unique Passwords</h2><hr>";

// Array email => password (sesuai data Anda)
$passwords = [
    'muliaabdullahidn@kamponginggrispare.com' => 'mulia8652',
    'mabdulfathiridn@kamponginggrispare.com' => 'muhammad2908',
    'altopsidn@kamponginggrispare.com' => 'althaf9575',
    'izzuhuzainazzam@kamponginggrispare.com' => 'azzam2313',
    'tsabitmumtazidn@kamponginggrispare.com' => 'tsabit3401',
    // ... tambahkan semua user lainnya dari list Anda
];

$updated = 0;
$errors = 0;

echo "<div style='max-height:500px;overflow:auto;background:#f5f5f5;padding:15px;border-radius:5px;'>";

foreach ($passwords as $email => $password) {
    try {
        // Generate hash
        $hash = Hash::make($password);
        
        // Update via DB (bypass model to avoid double hashing)
        $result = \DB::table('users')
            ->where('email', $email)
            ->update(['password' => $hash]);
        
        if ($result) {
            // Verify
            $user = \App\Models\User::where('email', $email)->first();
            if ($user && Hash::check($password, $user->password)) {
                echo "✅ <strong>$email</strong> → password: $password (verified)<br>";
                $updated++;
            } else {
                echo "⚠️ <strong>$email</strong> → updated but verification failed<br>";
                $errors++;
            }
        } else {
            echo "❌ <strong>$email</strong> → not found in database<br>";
            $errors++;
        }
    } catch (Exception $e) {
        echo "❌ <strong>$email</strong> → error: " . $e->getMessage() . "<br>";
        $errors++;
    }
}

echo "</div>";

echo "<hr>";
echo "<div style='background:#4CAF50;color:white;padding:20px;border-radius:10px;'>";
echo "<h3>✅ Update Complete!</h3>";
echo "<p><strong>Successfully Updated:</strong> $updated users</p>";
echo "<p><strong>Errors:</strong> $errors</p>";
echo "</div>";

echo "<hr>";
echo "<h3>Test Login:</h3>";
echo "<ul>";
echo "<li>Email: muliaabdullahidn@kamponginggrispare.com → Password: mulia8652</li>";
echo "<li>Email: mabdulfathiridn@kamponginggrispare.com → Password: muhammad2908</li>";
echo "<li>Email: altopsidn@kamponginggrispare.com → Password: althaf9575</li>";
echo "</ul>";
echo "<p><a href='/dashboard/'>Go to Login</a></p>";

echo "<hr>";
echo "<p style='color:red;'><strong>HAPUS file ini setelah selesai!</strong></p>";
?>