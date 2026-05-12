<?php
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "<h2>🧹 Clear Cache</h2><hr>";

try {
    // Clear config cache
    Artisan::call('config:clear');
    echo "✅ Config cache cleared<br>";
    
    // Clear application cache
    Artisan::call('cache:clear');
    echo "✅ Application cache cleared<br>";
    
    // Clear route cache
    Artisan::call('route:clear');
    echo "✅ Route cache cleared<br>";
    
    // Clear view cache
    Artisan::call('view:clear');
    echo "✅ View cache cleared<br>";
    
    echo "<hr>";
    echo "<div style='background:#4CAF50;color:white;padding:20px;border-radius:10px;'>";
    echo "<h3>✅ Cache Cleared Successfully!</h3>";
    echo "<p>Sekarang coba login dengan:</p>";
    echo "<p><strong>Email:</strong> admin@kamponginggrispare.com</p>";
    echo "<p><strong>Password:</strong> password123</p>";
    echo "<p><a href='/dashboard/' style='color:white;'>Klik di sini untuk login</a></p>";
    echo "</div>";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}

echo "<hr>";
echo "<p style='color:red;'>HAPUS file ini setelah selesai!</p>";
?>
```

### **2. Akses File:**
```
https://kamponginggrispare.com/dashboard/clear-cache.php