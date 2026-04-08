<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sektor;
use App\Models\Agency;
use App\Models\JenisAset;
use App\Models\Asset;
use App\Models\KategoriRisiko;
use App\Models\SubKategoriRisiko;
use App\Models\Risiko;
use App\Models\KategoriPuncaRisiko;
use App\Models\PuncaRisiko;
use App\Models\DaftarRisiko;

class DataSeeder extends Seeder
{
    public function run(): void
    {
        // Create sectors
        $sectors = [
            ['nama' => 'Pertahanan'],
            ['nama' => 'Kesihatan'],
            ['nama' => 'Pendidikan'],
            ['nama' => 'Telekomunikasi'],
            ['nama' => 'Kewangan'],
        ];

        foreach ($sectors as $sector) {
            Sektor::create($sector);
        }

        // Create asset types
        $assetTypes = [
            ['nama' => 'Server'],
            ['nama' => 'Komputer Meja'],
            ['nama' => 'Laptop'],
            ['nama' => 'Peranti Mudah Alih'],
            ['nama' => 'Peranti Rangkaian'],
            ['nama' => 'Storan Data'],
        ];

        foreach ($assetTypes as $type) {
            JenisAset::create($type);
        }

        // Create sample agencies
        $agencies = [
            [
                'nama_agensi' => 'Kementerian Pertahanan',
                'no_tel_agensi' => '03-1234-5678',
                'website' => 'https://www.mindef.gov.my',
                'nama_pic' => 'Datuk Ahmad',
                'notel_pic' => '011-1234-5678',
                'emel_pic' => 'ahmad@mindef.gov.my',
                'sektor_id' => 1,
                'jenis_agensi' => 'Kerajaan',
            ],
            [
                'nama_agensi' => 'Kementerian Kesihatan',
                'no_tel_agensi' => '03-2166-4500',
                'website' => 'https://www.moh.gov.my',
                'nama_pic' => 'Dr. Siti',
                'notel_pic' => '012-3456-7890',
                'emel_pic' => 'siti@moh.gov.my',
                'sektor_id' => 2,
                'jenis_agensi' => 'Kerajaan',
            ],
            [
                'nama_agensi' => 'Universiti Malaya',
                'no_tel_agensi' => '03-7967-5000',
                'website' => 'https://www.um.edu.my',
                'nama_pic' => 'Prof. Muhammad',
                'notel_pic' => '012-9876-5432',
                'emel_pic' => 'muhammad@um.edu.my',
                'sektor_id' => 3,
                'jenis_agensi' => 'Pendidikan',
            ],
            [
                'nama_agensi' => 'Universiti Teknologi Petronas',
                'no_tel_agensi' => '05-3688-6688',
                'website' => 'https://www.utp.edu.my',
                'nama_pic' => 'Prof. Rashid',
                'notel_pic' => '012-5555-6666',
                'emel_pic' => 'rashid@utp.edu.my',
                'sektor_id' => 3,
                'jenis_agensi' => 'Pendidikan',
            ],
            [
                'nama_agensi' => 'Bank Negara Malaysia',
                'no_tel_agensi' => '03-2698-8044',
                'website' => 'https://www.bnm.gov.my',
                'nama_pic' => 'Tan Sri Zafrul',
                'notel_pic' => '019-2222-3333',
                'emel_pic' => 'zafrul@bnm.gov.my',
                'sektor_id' => 5,
                'jenis_agensi' => 'Kerajaan',
            ],
        ];

        foreach ($agencies as $agency) {
            Agency::create($agency);
        }

        // Create sample assets
        $assets = [
            // Kementerian Pertahanan (agensi_id = 1)
            ['agensi_id' => 1, 'id_jenis_aset' => 1, 'nama_aset' => 'Server Pusat Data Pertahanan'],
            ['agensi_id' => 1, 'id_jenis_aset' => 2, 'nama_aset' => 'Komputer Pentadbir Pertahanan'],
            ['agensi_id' => 1, 'id_jenis_aset' => 3, 'nama_aset' => 'Laptop Komando Pertahanan'],
            ['agensi_id' => 1, 'id_jenis_aset' => 5, 'nama_aset' => 'Switch Rangkaian Pertahanan'],

            // Kementerian Kesihatan (agensi_id = 2)
            ['agensi_id' => 2, 'id_jenis_aset' => 3, 'nama_aset' => 'Laptop Pegawai Kesihatan'],
            ['agensi_id' => 2, 'id_jenis_aset' => 4, 'nama_aset' => 'iPad Klinik Kesihatan'],
            ['agensi_id' => 2, 'id_jenis_aset' => 1, 'nama_aset' => 'Server Database Kesihatan'],
            ['agensi_id' => 2, 'id_jenis_aset' => 6, 'nama_aset' => 'Storan Data Rekod Medis'],

            // Universiti Malaya (agensi_id = 3)
            ['agensi_id' => 3, 'id_jenis_aset' => 1, 'nama_aset' => 'Server Akademik UM'],
            ['agensi_id' => 3, 'id_jenis_aset' => 2, 'nama_aset' => 'Komputer Lab UM'],
            ['agensi_id' => 3, 'id_jenis_aset' => 3, 'nama_aset' => 'Laptop Profesor UM'],
            ['agensi_id' => 3, 'id_jenis_aset' => 5, 'nama_aset' => 'Router Kampus UM'],

            // Universiti Teknologi Petronas (agensi_id = 4)
            ['agensi_id' => 4, 'id_jenis_aset' => 1, 'nama_aset' => 'Server Utama UTP'],
            ['agensi_id' => 4, 'id_jenis_aset' => 3, 'nama_aset' => 'Laptop Pelajar UTP'],
            ['agensi_id' => 4, 'id_jenis_aset' => 6, 'nama_aset' => 'Terabyte Storage UTP'],

            // Bank Negara Malaysia (agensi_id = 5)
            ['agensi_id' => 5, 'id_jenis_aset' => 1, 'nama_aset' => 'Server Finansial BNM'],
            ['agensi_id' => 5, 'id_jenis_aset' => 6, 'nama_aset' => 'Sistem Backup BNM'],
            ['agensi_id' => 5, 'id_jenis_aset' => 5, 'nama_aset' => 'Firewall BNM'],
            ['agensi_id' => 5, 'id_jenis_aset' => 2, 'nama_aset' => 'Komputer Trading BNM'],
        ];

        foreach ($assets as $asset) {
            Asset::create($asset);
        }

        // Create risk categories
        $riskCategories = [
            ['nama' => 'Operasional'],
            ['nama' => 'Keamanan Siber'],
            ['nama' => 'Kewangan'],
            ['nama' => 'Kepatuhan Peraturan'],
            ['nama' => 'Reputasi'],
        ];

        foreach ($riskCategories as $category) {
            KategoriRisiko::create($category);
        }

        // Create sub-categories
        $subCategories = [
            ['kategori_risiko_id' => 1, 'nama' => 'Gangguan Operasi'],
            ['kategori_risiko_id' => 1, 'nama' => 'Kegagalan Proses'],
            ['kategori_risiko_id' => 2, 'nama' => 'Ancaman Dalaman'],
            ['kategori_risiko_id' => 2, 'nama' => 'Ancaman Luaran'],
            ['kategori_risiko_id' => 3, 'nama' => 'Kerugian Kewangan'],
            ['kategori_risiko_id' => 3, 'nama' => 'Penipuan'],
            ['kategori_risiko_id' => 4, 'nama' => 'Pelanggaran Perundangan'],
            ['kategori_risiko_id' => 5, 'nama' => 'Kerosakan Imej'],
        ];

        foreach ($subCategories as $subCategory) {
            SubKategoriRisiko::create($subCategory);
        }

        // Create risks
        $risks = [
            ['sub_kategori_risiko_id' => 1, 'nama' => 'Gangguan Sistem'],
            ['sub_kategori_risiko_id' => 1, 'nama' => 'Kehilangan Data'],
            ['sub_kategori_risiko_id' => 2, 'nama' => 'Proses Manual yang Tidak Efisien'],
            ['sub_kategori_risiko_id' => 3, 'nama' => 'Akses Tidak Dibenarkan'],
            ['sub_kategori_risiko_id' => 3, 'nama' => 'Pencurian Data Dalaman'],
            ['sub_kategori_risiko_id' => 4, 'nama' => 'Serangan Malware'],
            ['sub_kategori_risiko_id' => 4, 'nama' => 'Serangan DoS'],
            ['sub_kategori_risiko_id' => 5, 'nama' => 'Kehilangan Pendapatan'],
            ['sub_kategori_risiko_id' => 6, 'nama' => 'Penipuan Sistem Pembayaran'],
            ['sub_kategori_risiko_id' => 7, 'nama' => 'Pelanggaran PDPA'],
            ['sub_kategori_risiko_id' => 8, 'nama' => 'Publisiti Negatif'],
        ];

        foreach ($risks as $risk) {
            Risiko::create($risk);
        }

        // Create causes of risk - now directly under KategoriRisiko
        // Note: No longer need KategoriPuncaRisiko table
        // Each cause is associated with a specific risk category

        $puncas = [
            // Operasional (kategori_risiko_id = 1)
            ['kategori_risiko_id' => 1, 'nama' => 'Cakera Keras Gagal'],
            ['kategori_risiko_id' => 1, 'nama' => 'Sambungan Rangkaian Terputus'],
            ['kategori_risiko_id' => 1, 'nama' => 'Operator Menekan Butang Yang Salah'],

            // Keamanan Siber (kategori_risiko_id = 2)
            ['kategori_risiko_id' => 2, 'nama' => 'Penggodam Berpengalaman'],
            ['kategori_risiko_id' => 2, 'nama' => 'Serangan Phishing'],
            ['kategori_risiko_id' => 2, 'nama' => 'Malware Terinfeksi'],

            // Kewangan (kategori_risiko_id = 3)
            ['kategori_risiko_id' => 3, 'nama' => 'Kesalahan Perakaunan'],
            ['kategori_risiko_id' => 3, 'nama' => 'Penipuan Sistem Pembayaran'],

            // Kepatuhan Peraturan (kategori_risiko_id = 4)
            ['kategori_risiko_id' => 4, 'nama' => 'Undang-undang Baru Diluluskan'],
            ['kategori_risiko_id' => 4, 'nama' => 'Ketidakpatuhan Operasi'],

            // Reputasi (kategori_risiko_id = 5)
            ['kategori_risiko_id' => 5, 'nama' => 'Publisiti Negatif Media Sosial'],
            ['kategori_risiko_id' => 5, 'nama' => 'Kehilangan Kepercayaan Pelanggan'],
        ];

        foreach ($puncas as $punca) {
            PuncaRisiko::create($punca);
        }

        // Create dummy risk registrations for reports
        $this->createDummyRiskRegistrations();
    }

    private function createDummyRiskRegistrations(): void
    {
        // Get all necessary data
        $agencies = Agency::all();
        $assets = Asset::all();
        $risks = Risiko::with('subKategoriRisiko')->get();
        $puncas = PuncaRisiko::all();

        // Risk levels and their multipliers
        $levels = ['Rendah', 'Sederhana', 'Tinggi'];
        $scoreMap = ['Rendah' => 3, 'Sederhana' => 7, 'Tinggi' => 9];

        // For each agency, create multiple risk registrations
        foreach ($agencies as $agency) {
            $agencyAssets = $agency->assets()->get();

            if ($agencyAssets->isEmpty()) {
                continue;
            }

            // Create 15-25 risk registrations per agency to generate meaningful reports
            $registrationCount = rand(15, 25);

            for ($i = 0; $i < $registrationCount; $i++) {
                $asset = $agencyAssets->random();
                $risk = $risks->random();
                $tahapRisiko = $levels[array_rand($levels)];
                $punca = $puncas->random();

                $kebarangkalian = rand(1, 5);
                $impak = rand(1, 5);
                $skorRisiko = $kebarangkalian * $impak;

                DaftarRisiko::create([
                    'agensi_id' => $agency->id,
                    'aset_id' => $asset->id,
                    'kategori_id' => $risk->subKategoriRisiko->kategori_risiko_id,
                    'sub_kategori_risiko_id' => $risk->sub_kategori_risiko_id,
                    'risiko_id' => $risk->id,
                    'punca_risiko_id' => $punca->id,
                    'kategori_punca_risiko_id' => null,
                    'impak' => $impak,
                    'kebarangkalian' => $kebarangkalian,
                    'skor_risiko' => $skorRisiko,
                    'tahap_risiko' => $tahapRisiko,
                    'kawalan_sediada' => 'Ya',
                    'plan_mitigasi' => 'Dalam Perkembangan',
                    'pemilik_risiko' => 'Pentadbir Sistem',
                ]);
            }
        }
    }
}
