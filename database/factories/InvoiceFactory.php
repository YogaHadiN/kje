<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Invoice;

class InvoiceFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = Invoice::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'kirim_berkas_id' => \App\Models\KirimBerkas::factory(),
            'pembayaran_asuransi_id' => \App\Models\PembayaranAsuransi::factory(),
            'received_verification' => $this->faker->word,
            'tenant_id' => \App\Models\Tenant::factory(),
            'kode_invoice' => $this->faker->word,
        ];
    }
}
