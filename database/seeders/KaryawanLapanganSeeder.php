<?php

namespace Database\Seeders;

use App\Models\Karyawan;
use App\Models\KaryawanLapangan;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class KaryawanLapanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan afdeling_id yang digunakan sudah ada di tabel afdeling
        $karyawanData = [
            [
                'afdeling_id' => 5,
                'nama' => 'Ahmad Santoso',
                'jabatan' => 'MDR Panen',
                'tanggal_masuk' => Carbon::create(2019, 5, 15),
                'lokasi_kerja' => 'Blok A1-A3'
            ],
            [
                'afdeling_id' => 5,
                'nama' => 'Budi Setiawan',
                'jabatan' => 'MDR Pemeliharaan',
                'tanggal_masuk' => Carbon::create(2020, 2, 10),
                'lokasi_kerja' => 'Blok A1-A5'
            ],
            [
                'afdeling_id' => 5,
                'nama' => 'Citra Dewi',
                'jabatan' => 'Petugas Timbang BRD',
                'tanggal_masuk' => Carbon::create(2021, 8, 22),
                'lokasi_kerja' => 'Pos Timbang Utara'
            ],
            [
                'afdeling_id' => 5,
                'nama' => 'Dedi Kurniawan',
                'jabatan' => 'Mandor',
                'tanggal_masuk' => Carbon::create(2018, 3, 5),
                'lokasi_kerja' => 'Blok B1-B4'
            ],
            [
                'afdeling_id' => 5,
                'nama' => 'Eka Prasetyo',
                'jabatan' => 'Asisten Kebun',
                'tanggal_masuk' => Carbon::create(2017, 11, 18),
                'lokasi_kerja' => 'Blok C1-C6'
            ]
        ];

        foreach ($karyawanData as $data) {
            KaryawanLapangan::create($data);
        }

        $this->command->info('Seeder karyawan berhasil diisi!');
    }
}