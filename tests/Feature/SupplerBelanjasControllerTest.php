<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Supplier;
use Illuminate\Http\Testing\File;
use Storage;

class SupplerBelanjasControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    /**
     * @group failing
     */
}
/* Route::get('suppliers/belanja_bukan_obat', [\App\Http\Controllers\SupplierBelanjasController::class, 'belanja_bukan_obat']); */
