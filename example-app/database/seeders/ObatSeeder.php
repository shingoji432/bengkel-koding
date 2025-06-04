<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ObatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $obats = [
            [
                'nama_obat' => 'Paracetamol',
                'kemasan' => 'Tablet 500mg',
                'harga' => 5000
            ],
            [
                'nama_obat' => 'Amoxicillin',
                'kemasan' => 'Kapsul 500mg',
                'harga' => 12000
            ],
            [
                'nama_obat' => 'Cetirizine',
                'kemasan' => 'Tablet 10mg',
                'harga' => 8000
            ],
            [
                'nama_obat' => 'Omeprazole',
                'kemasan' => 'Kapsul 20mg',
                'harga' => 15000
            ],
            [
                'nama_obat' => 'Ibuprofen',
                'kemasan' => 'Tablet 400mg',
                'harga' => 7000
            ],
            [
                'nama_obat' => 'Loratadine',
                'kemasan' => 'Tablet 10mg',
                'harga' => 9000
            ],
            [
                'nama_obat' => 'Metformin',
                'kemasan' => 'Tablet 500mg',
                'harga' => 10000
            ],
            [
                'nama_obat' => 'Simvastatin',
                'kemasan' => 'Tablet 20mg',
                'harga' => 25000
            ],
            [
                'nama_obat' => 'Aspirin',
                'kemasan' => 'Tablet 80mg',
                'harga' => 6000
            ],
            [
                'nama_obat' => 'Dexamethasone',
                'kemasan' => 'Tablet 0.5mg',
                'harga' => 18000
            ],
            [
                'nama_obat' => 'Furosemide',
                'kemasan' => 'Tablet 40mg',
                'harga' => 11000
            ],
            [
                'nama_obat' => 'Metronidazole',
                'kemasan' => 'Tablet 500mg',
                'harga' => 13000
            ],
            [
                'nama_obat' => 'Ranitidine',
                'kemasan' => 'Tablet 150mg',
                'harga' => 14000
            ],
            [
                'nama_obat' => 'Salbutamol',
                'kemasan' => 'Inhaler 100mcg',
                'harga' => 45000
            ],
            [
                'nama_obat' => 'Ciprofloxacin',
                'kemasan' => 'Tablet 500mg',
                'harga' => 20000
            ],
            [
                'nama_obat' => 'Diazepam',
                'kemasan' => 'Tablet 5mg',
                'harga' => 22000
            ],
            [
                'nama_obat' => 'Losartan',
                'kemasan' => 'Tablet 50mg',
                'harga' => 30000
            ],
            [
                'nama_obat' => 'Amlodipine',
                'kemasan' => 'Tablet 5mg',
                'harga' => 17000
            ],
            [
                'nama_obat' => 'Vitamin C',
                'kemasan' => 'Tablet 500mg',
                'harga' => 5000
            ],
            [
                'nama_obat' => 'Vitamin B Complex',
                'kemasan' => 'Kapsul',
                'harga' => 12000
            ]
        ];

        foreach ($obats as $obat) {
            Obat::create($obat);
        }
    }
}
