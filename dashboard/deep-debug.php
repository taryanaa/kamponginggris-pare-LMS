<?php
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "<style>
body { font-family: Arial; padding: 20px; }
.success { background: #4CAF50; color: white; padding: 15px; border-radius: 5px; margin: 10px 0; }
.error { background: #f44336; color: white; padding: 15px; border-radius: 5px; margin: 10px 0; }
.info { background: #2196F3; color: white; padding: 15px; border-radius: 5px; margin: 10px 0; }
code { background: #f0f0f0; padding: 2px 5px; font-size: 11px; }
</style>";

echo "<h1>🔍 Deep Authentication Debug</h1><hr>";

$email = 'admin@kamponginggrispare.com';
$testPassword = 'password123';

// 1. Get User
echo "<h2>Step 1: Get User from Database</h2>";
$user = User::where('email', $email)->first();

if (!$user) {
    echo "<div class='error'>❌ User not found!</div>";
    exit;
}

echo "<div class='success'>✅ User found: {$user->email}</div>";
echo "<p><strong>Current password hash in DB:</strong><br><code>{$user->password}</code></p>";

// 2. Check hash format
echo "<h2>Step 2: Check Hash Format</h2>";
if (substr($user->password, 0, 4) === '$2y$') {
    echo "<div class='success'>✅ Hash format looks correct (bcrypt)</div>";
} else {
    echo "<div class='error'>❌ Hash format is WRONG! Should start with \$2y\$</div>";
}

// 3. Test Hash::check
echo "<h2>Step 3: Test Hash::check()</h2>";
$hashCheck = Hash::check($testPassword, $user->password);
echo $hashCheck 
    ? "<div class='success'>✅ Hash::check PASSED</div>" 
    : "<div class='error'>❌ Hash::check FAILED</div>";

// 4. Test native password_verify
echo "<h2>Step 4: Test native password_verify()</h2>";
$nativeCheck = password_verify($testPassword, $user->password);
echo $nativeCheck 
    ? "<div class='success'>✅ password_verify PASSED</div>" 
    : "<div class='error'>❌ password_verify FAILED</div>";

// 5. Check User Model casts
echo "<h2>Step 5: Check User Model Configuration</h2>";
$casts = $user->getCasts();
echo "<p><strong>Model casts:</strong></p><pre>";
print_r($casts);
echo "</pre>";

if (isset($casts['password'])) {
    echo "<div class='error'>❌ PROBLEM FOUND! Password has automatic cast: {$casts['password']}<br>";
    echo "This causes DOUBLE HASHING!</div>";
} else {
    echo "<div class='success'>✅ No password cast (good)</div>";
}

// 6. Generate fresh hash
echo "<h2>Step 6: Generate Fresh Hash</h2>";
$freshHash = Hash::make($testPassword);
echo "<p><strong>Fresh hash:</strong><br><code>$freshHash</code></p>";

$freshCheck = Hash::check($testPassword, $freshHash);
echo $freshCheck 
    ? "<div class='success'>✅ Fresh hash verification PASSED</div>" 
    : "<div class='error'>❌ Fresh hash verification FAILED (Hash system broken!)</div>";

// 7. Direct password update (bypassing model)
echo "<h2>Step 7: Fix - Direct Database Update</h2>";

try {
    // Use DB facade to bypass model
    \DB::table('users')
        ->where('email', $email)
        ->update(['password' => $freshHash]);
    
    echo "<div class='success'>✅ Password updated directly in database</div>";
    
    // Reload user
    $user = User::where('email', $email)->first();
    echo "<p><strong>New hash in DB:</strong><br><code>{$user->password}</code></p>";
    
    // Test again
    $finalCheck = Hash::check($testPassword, $user->password);
    
    if ($finalCheck) {
        echo "<div class='success'>";
        echo "<h3>🎉 SUCCESS! Password is now correct!</h3>";
        echo "<p><strong>Login with:</strong></p>";
        echo "<p>Email: admin@kamponginggrispare.com<br>";
        echo "Password: password123</p>";
        echo "<a href='/dashboard/' style='color:white;text-decoration:underline;font-size:18px;'>→ Login Now</a>";
        echo "</div>";
    } else {
        echo "<div class='error'>❌ Still failed after direct update</div>";
        
        // Show comparison
        echo "<h3>Hash Comparison:</h3>";
        echo "<p>Fresh generated: <code>$freshHash</code></p>";
        echo "<p>After DB save: <code>{$user->password}</code></p>";
        
        if ($freshHash !== $user->password) {
            echo "<div class='error'>⚠️ HASHES ARE DIFFERENT! Model is modifying the password on retrieval!</div>";
        }
    }
    
} catch (Exception $e) {
    echo "<div class='error'>❌ Error: " . $e->getMessage() . "</div>";
}

echo "<hr>";
echo "<div class='info'>";
echo "<h3>Next Steps:</h3>";
echo "<ol>";
echo "<li>Clear cache: <a href='clear-cache.php' style='color:white;'>clear-cache.php</a></li>";
echo "<li>Try login: <a href='/dashboard/' style='color:white;'>Login Page</a></li>";
echo "<li><strong style='color:yellow;'>DELETE this file after success!</strong></li>";
echo "</ol>";
echo "</div>";
?>