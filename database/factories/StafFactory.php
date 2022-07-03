<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Staf;
use App\Models\Tenant;
use App\Models\Classes\Yoga;

class StafFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Staf::class;
    public function definition()
    {
        $nama             = $this->faker->name;
        $alamat_domisili  = $this->faker->address;
        $tanggal_lahir    = $this->faker->date('d-m-Y');
        $ktp              = $this->faker->numerify('################');
        $email            = $this->faker->email;
        $no_telp          = $this->faker->phoneNumber();
        $alamat_ktp       = $this->faker->address;
        $str              = $this->faker->numerify('################');;
        $universitas_asal = $this->faker->name;
        $titel            = "dr";
        $no_hp            = $this->faker->phoneNumber();
        $tanggal_lulus    = $this->faker->date('d-m-Y');
        $tanggal_mulai    = $this->faker->date('d-m-Y');
        $menikah          = "1";
        $jumlah_anak      = "1";
        $npwp             = $this->faker->numerify('################');;
        $jenis_kelamin    = "1";
        $sip              = $this->faker->numerify('################');;
        $nomor_rekening   = $this->faker->numerify('################');;
        $bank             = $this->faker->text;
        $tenant_id        = Tenant::factory();
        $image            = null;
        $ktp_image        = null;
        $str_image        = null;
        $sip_image        = null;
        $gambar_npwp      = null;
        $kartu_keluarga   = null;

        return [
            "nama"             => $nama,
            "alamat_domisili"  => $alamat_domisili,
            "tanggal_lahir"    => $tanggal_lahir,
            "ktp"              => $ktp,
            "email"            => $email,
            "no_telp"          => $no_telp,
            "alamat_ktp"       => $alamat_ktp,
            "str"              => $str,
            "universitas_asal" => $universitas_asal,
            "titel"            => $titel,
            "no_hp"            => $no_hp,
            "tanggal_lulus"    => $tanggal_lulus,
            "tanggal_mulai"    => $tanggal_mulai,
            "menikah"          => $menikah,
            "jumlah_anak"      => $jumlah_anak,
            "npwp"             => $npwp,
            "jenis_kelamin"    => $jenis_kelamin,
            "sip"              => $sip,
            "nomor_rekening"   => $nomor_rekening,
            "bank"             => $bank,
            "image"            => $image,
            "ktp_image"        => $ktp_image,
            "str_image"        => $str_image,
            "sip_image"        => $sip_image,
            "gambar_npwp"      => $gambar_npwp,
            "kartu_keluarga"   => $kartu_keluarga,
            "tenant_id"        => $tenant_id,
        ];
    }
}
