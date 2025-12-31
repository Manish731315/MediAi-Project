<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Medicine;

class MedicineSeeder extends Seeder
{
    public function run(): void
    {
        Medicine::create([
            'name' => 'Paracetamol 500mg',
            'description' => 'For relief from fever and mild pain.',
            'price' => 20.50,
            'stock' => 100,
            'category' => 'Pain Relief',
            'prescription_required' => false
        ]);
        
        Medicine::create([
            'name' => 'Cough Syrup (OTC)',
            'description' => 'For relief from dry cough.',
            'price' => 85.00,
            'stock' => 50,
            'category' => 'Cold & Cough',
            'prescription_required' => false
        ]);

        Medicine::create([
            'name' => 'Antacid Tablets',
            'description' => 'For relief from acidity and indigestion.',
            'price' => 45.00,
            'stock' => 75,
            'category' => 'Stomach',
            'prescription_required' => false
        ]);
        
        Medicine::create([
            'name' => 'Amoxicillin 250mg',
            'description' => 'Antibiotic for bacterial infections. Requires prescription.',
            'price' => 120.00,
            'stock' => 30,
            'category' => 'Antibiotic',
            'prescription_required' => true
        ]);
    }
}