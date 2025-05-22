<?php

namespace Tests\Feature;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\SubKategori;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BarangControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $token;
    protected $kategori;
    protected $subKategori;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create authenticated user with valid role
        $this->user = User::factory()->create([
            'role' => 'admin',
        ]);
        $this->token = $this->user->createToken('test-token')->plainTextToken;

        // Create test category and subcategory
        $this->kategori = Kategori::create(['nama' => 'Test Kategori']);
        $this->subKategori = SubKategori::create([
            'kategori_id' => $this->kategori->id,
            'nama' => 'Test Sub Kategori'
        ]);
    }

    public function test_can_get_all_barang()
    {
        // Create some test barang records
        Barang::create([
            'nama_barang' => 'Test Barang 1',
            'kode_barang' => 'B001',
            'sub_kategori_id' => $this->subKategori->id,
            'kondisi' => 'baik',
            'jumlah' => 5,
            'jumlah_tersedia' => 5,
            'status' => 'tersedia',
        ]);

        Barang::create([
            'nama_barang' => 'Test Barang 2',
            'kode_barang' => 'B002',
            'sub_kategori_id' => $this->subKategori->id,
            'kondisi' => 'baik',
            'jumlah' => 3,
            'jumlah_tersedia' => 2,
            'status' => 'tersedia',
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson('/api/barangs');

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data');
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id', 'nama_barang', 'kode_barang', 'sub_kategori_id', 
                    'kondisi', 'jumlah', 'jumlah_tersedia', 'status'
                ]
            ]
        ]);
    }

    public function test_can_create_barang()
    {
        Storage::fake('public');
        
        $barangData = [
            'nama_barang' => 'New Test Barang',
            'kode_barang' => 'B003',
            'sub_kategori_id' => $this->subKategori->id,
            'kondisi' => 'baik',
            'jumlah' => 10,
            'jumlah_tersedia' => 10,
            'status' => 'tersedia',
            'lokasi' => 'Test Location',
            'keterangan' => 'Test notes',
            'gambar' => UploadedFile::fake()->image('barang.jpg')
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->postJson('/api/barangs', $barangData);

        $response->assertStatus(201);
        
        // Check that the barang was created in the database
        $this->assertDatabaseHas('barangs', [
            'nama_barang' => 'New Test Barang',
            'kode_barang' => 'B003',
        ]);
        
        // If image handling is implemented, check that the file was stored
        if ($response->json('gambar_path')) {
            Storage::disk('public')->assertExists($response->json('gambar_path'));
        }
    }

    public function test_can_update_barang()
    {
        // Create a barang to update
        $barang = Barang::create([
            'nama_barang' => 'Barang to Update',
            'kode_barang' => 'B004',
            'sub_kategori_id' => $this->subKategori->id,
            'kondisi' => 'baik',
            'jumlah' => 5,
            'jumlah_tersedia' => 5,
            'status' => 'tersedia',
        ]);

        $updateData = [
            'nama_barang' => 'Updated Barang Name',
            'kondisi' => 'kurang_baik',
            'jumlah' => 6,
            'jumlah_tersedia' => 5,
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->putJson("/api/barangs/{$barang->id}", $updateData);

        $response->assertStatus(200);
        
        // Check that the database was updated
        $this->assertDatabaseHas('barangs', [
            'id' => $barang->id,
            'nama_barang' => 'Updated Barang Name',
            'kondisi' => 'kurang_baik',
            'jumlah' => 6,
        ]);
    }

    public function test_can_delete_barang()
    {
        // Create a barang to delete
        $barang = Barang::create([
            'nama_barang' => 'Barang to Delete',
            'kode_barang' => 'B005',
            'sub_kategori_id' => $this->subKategori->id,
            'kondisi' => 'baik',
            'jumlah' => 2,
            'jumlah_tersedia' => 2,
            'status' => 'tersedia',
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->deleteJson("/api/barangs/{$barang->id}");

        $response->assertStatus(200);
        
        // Check that the barang was deleted
        $this->assertDatabaseMissing('barangs', [
            'id' => $barang->id,
        ]);
    }
} 