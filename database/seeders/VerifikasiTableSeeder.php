<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HubunganKeluarga;
use App\Models\VerifikasiWajah;

class VerifikasiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $timestamp = date('Y-m-d H:i:s');
        VerifikasiWajah::insert([
            [
                'verifikasi' => 'Foto pasien di aplikasi sama dengan wajah pasien'
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],
            [
                'verifikasi' => 'Foto pasien tidak jelas'
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],
            [
                'verifikasi' => 'Foto pasien tidak sama dengan wajah pasien'
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],
        ]);
        HubunganKeluarga::insert([
            [
                'hubungan_keluarga' => 'Ayah'
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],
            [
                'hubungan_keluarga' => 'Ibu'
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],
            [
                'hubungan_keluarga' => 'Anak'
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],
            [
                'hubungan_keluarga' => 'Lainnya'
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ],
        ]);
        DB::statement("Update pasiens set kepala_keluarga_id = id;")
        DB::statement("Update pasiens set hubungan_keluarga_id = 4;")
    }
}
