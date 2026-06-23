<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Pending prescriptions: " . \App\Models\Prescription::where('status', 'pending')->count() . "\n";

$p = \App\Models\Prescription::where('status', 'pending')->first();
if ($p) {
    echo "Prescription ID: {$p->id}, Patient ID: {$p->patient_id}, Doctor ID: {$p->doctor_id}\n";
    echo "Medicines count: " . $p->medicines->count() . "\n";
    $p->load(['patient.user', 'doctor.user']);
    echo "Patient name: " . ($p->patient->user->name ?? 'N/A') . "\n";
    echo "Doctor name: " . ($p->doctor->user->name ?? 'N/A') . "\n";
} else {
    echo "No pending prescription found\n";
}
