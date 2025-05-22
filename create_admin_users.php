<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Admin pertama
$admin1 = new \App\Models\User();
$admin1->name = 'Admin Satu';
$admin1->email = 'admin1@smksasmita.ac.id';
$admin1->password = bcrypt('Admin123!');
$admin1->role = 'admin';
$admin1->email_verified_at = now();
$admin1->save();
echo "Admin 1 created: admin1@smksasmita.ac.id / Admin123!\n";

// Admin kedua
$admin2 = new \App\Models\User();
$admin2->name = 'Admin Dua';
$admin2->email = 'admin2@smksasmita.ac.id';
$admin2->password = bcrypt('Admin123!');
$admin2->role = 'admin';
$admin2->email_verified_at = now();
$admin2->save();
echo "Admin 2 created: admin2@smksasmita.ac.id / Admin123!\n";

// Admin ketiga
$admin3 = new \App\Models\User();
$admin3->name = 'Admin Tiga';
$admin3->email = 'admin3@smksasmita.ac.id';
$admin3->password = bcrypt('Admin123!');
$admin3->role = 'admin';
$admin3->email_verified_at = now();
$admin3->save();
echo "Admin 3 created: admin3@smksasmita.ac.id / Admin123!\n";

echo "Selesai! 3 akun admin telah dibuat.\n"; 