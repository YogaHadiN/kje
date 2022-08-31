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

class SuppliersControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_index(){
            $user     = User::factory()->create([
                'role_id' => 6
            ]);
        
        auth()->login($user);
        $response = $this->get('suppliers');
        $response->assertStatus(200);
    }
    public function test_create_view(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);
        $response = $this->get('suppliers/create');
        $response->assertStatus(200);
    }
    public function test_store(){
        Storage::fake('s3');
        // make a request with file


        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);

        /* sebelum kesini ke acting as dulu */
        /* key mapping j */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* $nama = $this->faker->text */

        $nama    = $this->faker->name;
        $alamat  = $this->faker->address;
        $no_telp = $this->faker->phoneNumber();
        $hp_pic  = $this->faker->phoneNumber();
        $pic     = $this->faker->name;

        /* sebelum kesini ke acting as dulu */
        /* key mapping l */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* $nama = File::create('nama.png', 100) */

        $image      = File::create('image.png', 100);
        $muka_image = File::create('muka_image.png', 100);;

        $this->withoutExceptionHandling();

        /* key mapping k */
        /* dari bentuk "nama	varchar(255)	NO		NULL" */	
        /* KE BENTUK */	
        /* "nama" => $nama, */

        $inputAll = [
            "nama"       => $nama,
            "alamat"     => $alamat,
            "no_telp"    => $no_telp,
            "hp_pic"     => $hp_pic,
            "pic"        => $pic,
            "image"      => $image,
            "muka_image" => $muka_image,
        ];

        $response = $this->post('suppliers', $inputAll);

        /* key mapping h */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* ->where("nama", $nama) */

        $suppliers = Supplier::query()
            ->where("nama", $nama)
            ->where("alamat", $alamat)
            ->where("no_telp", $no_telp)
            ->where("pic", $pic)
            ->where("hp_pic", $hp_pic)
        ->get();

            /* if ( !$suppliers->count() ) { */
            /*     $suppliers = Supplier::all(); */
            /*     $supplier_array = []; */
            /*     foreach ($suppliers as $a) { */
            /*         $supplier_array[] = [ */
            /*             "nama"             => $a->nama, */
            /*         ]; */
            /*     } */
            /*     dd(  [ */
            /*             "nama"             => $nama, */
            /*         ], */
            /*         $supplier_array */
            /*     ); */
            /* } */

        $this->assertCount(1, $suppliers);

        $supplier = $suppliers->first();

        // report was created and file was stored

        /* key mapping g */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* $this->checkForUploadedFile($nama, $model->nama); */

        checkForUploadedFile($image, $supplier->image);
        checkForUploadedFile($muka_image, $supplier->muka_image);

        $response->assertRedirect('suppliers');
    }
    /**
     * 
     */
    public function test_update(){
        Storage::fake('s3');
        // make a request with file


        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);

        /* sebelum kesini ke acting as dulu */
        /* key mapping j */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* $nama = $this->faker->text */

        $nama    = $this->faker->name;
        $alamat  = $this->faker->address;
        $no_telp = $this->faker->phoneNumber();
        $hp_pic  = $this->faker->phoneNumber();
        $pic     = $this->faker->name;

        /* sebelum kesini ke acting as dulu */
        /* key mapping l */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* $nama = File::create('nama.png', 100) */

        $image      = File::create('image.png', 100);
        $muka_image = File::create('muka_image.png', 100);;

        $this->withoutExceptionHandling();

        /* key mapping k */
        /* dari bentuk "nama	varchar(255)	NO		NULL" */	
        /* KE BENTUK */	
        /* "nama" => $nama, */

        $inputAll = [
            "nama"       => $nama,
            "alamat"     => $alamat,
            "no_telp"    => $no_telp,
            "hp_pic"     => $hp_pic,
            "pic"        => $pic,
            "image"      => $image,
            "muka_image" => $muka_image,
        ];

        $supplier = \App\Models\Supplier::factory()->create();
        $response = $this->put('suppliers/' . $supplier->id, $inputAll);

        /* key mapping h */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* ->where("nama", $nama) */

        $suppliers = Supplier::query()
            ->where("nama", $nama)
            ->where("alamat", $alamat)
            ->where("no_telp", $no_telp)
            ->where("pic", $pic)
            ->where("hp_pic", $hp_pic)
        ->get();


        $this->assertCount(1, $suppliers);

        $supplier = $suppliers->first();

        // report was created and file was stored

        /* key mapping g */
        /* dari bentuk '"nama"  => $nama,' */	
        /* KE BENTUK */	
        /* $this->checkForUploadedFile($nama, $model->nama); */

        checkForUploadedFile($image, $supplier->image);
        checkForUploadedFile($muka_image, $supplier->muka_image);

        $response->assertRedirect('suppliers');
    }
    public function test_show(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);
        $supplier = Supplier::factory()->create();
        $response = $this->get('suppliers/' . $supplier->id);
        $response->assertStatus(200);
    }
    public function test_edit(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);
        $supplier = Supplier::factory()->create();
        $response = $this->get('suppliers/' . $supplier->id . '/edit');
        $response->assertStatus(200);
    }
    public function test_destroy(){
        $user     = User::factory()->create([
                'role_id' => 6
            ]);
        auth()->login($user);
        $supplier = Supplier::factory()->create();
        $response = $this->delete('suppliers/' . $supplier->id);
        $response->assertRedirect('suppliers');
        $this->assertDeleted($supplier);
    }
}
/* Route::resource('suppliers', \App\Http\Controllers\SuppliersController::class); */
