<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Agency;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Get agencies that were created in DataSeeder
        $agencyPertahanan = Agency::where('nama_agensi', 'Kementerian Pertahanan')->first();
        $agencyKesihatan = Agency::where('nama_agensi', 'Kementerian Kesihatan')->first();
        $agencyUniversiti = Agency::where('nama_agensi', 'Universiti Malaya')->first();
        $agencyUTP = Agency::where('nama_agensi', 'Universiti Teknologi Petronas')->first();
        $agencyBNM = Agency::where('nama_agensi', 'Bank Negara Malaysia')->first();

        // Admin user (no agency needed)
        User::create([
            'name' => 'Admin Risiko Quantum',
            'email' => 'admin@riskoquantum.my',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'agensi_id' => null,
        ]);

        // Agency user for Kementerian Pertahanan
        if ($agencyPertahanan) {
            User::create([
                'name' => 'User Kementerian Pertahanan',
                'email' => 'pertahanan@riskoquantum.my',
                'password' => Hash::make('password123'),
                'role' => 'agency',
                'agensi_id' => $agencyPertahanan->id,
            ]);
        }

        // Agency user for Kementerian Kesihatan
        if ($agencyKesihatan) {
            User::create([
                'name' => 'User Kementerian Kesihatan',
                'email' => 'kesihatan@riskoquantum.my',
                'password' => Hash::make('password123'),
                'role' => 'agency',
                'agensi_id' => $agencyKesihatan->id,
            ]);
        }

        // Agency user for Universiti Malaya
        if ($agencyUniversiti) {
            User::create([
                'name' => 'User Universiti Malaya',
                'email' => 'um@riskoquantum.my',
                'password' => Hash::make('password123'),
                'role' => 'agency',
                'agensi_id' => $agencyUniversiti->id,
            ]);
        }

        // Agency user for UTP
        if ($agencyUTP) {
            User::create([
                'name' => 'User Universiti Teknologi Petronas',
                'email' => 'utp@riskoquantum.my',
                'password' => Hash::make('password123'),
                'role' => 'agency',
                'agensi_id' => $agencyUTP->id,
            ]);
        }

        // Agency user for BNM
        if ($agencyBNM) {
            User::create([
                'name' => 'User Bank Negara Malaysia',
                'email' => 'bnm@riskoquantum.my',
                'password' => Hash::make('password123'),
                'role' => 'agency',
                'agensi_id' => $agencyBNM->id,
            ]);
        }

        // Test Admin
        User::create([
            'name' => 'Test Admin',
            'email' => 'test.admin@riskoquantum.my',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'agensi_id' => null,
        ]);
    }
}
