<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kategori;
use App\Models\Sparepart;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Admin User
        User::updateOrCreate(
            ['email' => 'admin@zoiezmotor.com'],
            [
                'name' => 'Admin Zoiez Motor',
                'password' => Hash::make('admin123'),
            ]
        );

        // 2. Seed Categories
        $pelumas = Kategori::updateOrCreate(
            ['nama_kategori' => 'Pelumas'],
            ['deskripsi' => 'Segala jenis oli mesin, oli gardan, dan minyak rem.']
        );

        $rem = Kategori::updateOrCreate(
            ['nama_kategori' => 'Sistem Pengereman'],
            ['deskripsi' => 'Kampas rem, piringan cakram, master rem, dan tromol.']
        );

        $transmisi = Kategori::updateOrCreate(
            ['nama_kategori' => 'Transmisi & Rantai'],
            ['deskripsi' => 'V-belt, roller, gear set, rantai roda, dan kampas ganda.']
        );

        $kelistrikan = Kategori::updateOrCreate(
            ['nama_kategori' => 'Kelistrikan & Pengapian'],
            ['deskripsi' => 'Aki, busi, kiprok, CDI, bohlam lampu, dan kabel bodi.']
        );

        $ban = Kategori::updateOrCreate(
            ['nama_kategori' => 'Ban & Roda'],
            ['deskripsi' => 'Ban luar tubeless, ban dalam, dan velg roda.']
        );

        // 3. Define Spareparts to seed (with initial stock = 0)
        $sparepartsData = [
            [
                'kode_sparepart' => 'SP-001',
                'kategori_id' => $pelumas->id,
                'nama_sparepart' => 'Oli MPX2 800ml',
                'merk' => 'AHM',
                'satuan' => 'pcs',
                'harga_beli' => 45000,
                'harga_jual' => 52000,
                'stok' => 0,
                'stok_minimal' => 10,
                'keterangan' => 'Oli mesin sepeda motor matic Honda.',
            ],
            [
                'kode_sparepart' => 'SP-002',
                'kategori_id' => $pelumas->id,
                'nama_sparepart' => 'Oli Yamalube Super Sport 1L',
                'merk' => 'Yamaha',
                'satuan' => 'pcs',
                'harga_beli' => 75000,
                'harga_jual' => 88000,
                'stok' => 0,
                'stok_minimal' => 8,
                'keterangan' => 'Oli mesin motor sport Yamaha.',
            ],
            [
                'kode_sparepart' => 'SP-003',
                'kategori_id' => $rem->id,
                'nama_sparepart' => 'Kampas Rem Depan Beat FI',
                'merk' => 'Federal',
                'satuan' => 'pcs',
                'harga_beli' => 25000,
                'harga_jual' => 32000,
                'stok' => 0,
                'stok_minimal' => 10,
                'keterangan' => 'Kampas rem cakram depan seri matic Honda.',
            ],
            [
                'kode_sparepart' => 'SP-004',
                'kategori_id' => $rem->id,
                'nama_sparepart' => 'Kampas Rem Belakang Vario',
                'merk' => 'AHM',
                'satuan' => 'pcs',
                'harga_beli' => 30000,
                'harga_jual' => 38000,
                'stok' => 0,
                'stok_minimal' => 10,
                'keterangan' => 'Kampas rem tromol belakang matic Honda.',
            ],
            [
                'kode_sparepart' => 'SP-005',
                'kategori_id' => $transmisi->id,
                'nama_sparepart' => 'V-Belt Kit Beat FI',
                'merk' => 'Honda Genuine Parts',
                'satuan' => 'set',
                'harga_beli' => 120000,
                'harga_jual' => 145000,
                'stok' => 0,
                'stok_minimal' => 5,
                'keterangan' => 'Satu set V-Belt dan roller standar.',
            ],
            [
                'kode_sparepart' => 'SP-006',
                'kategori_id' => $transmisi->id,
                'nama_sparepart' => 'Gear Set Supra X 125',
                'merk' => 'Federal',
                'satuan' => 'set',
                'harga_beli' => 140000,
                'harga_jual' => 165000,
                'stok' => 0,
                'stok_minimal' => 5,
                'keterangan' => 'Gear depan, gear belakang, dan rantai Supra X 125.',
            ],
            [
                'kode_sparepart' => 'SP-007',
                'kategori_id' => $kelistrikan->id,
                'nama_sparepart' => 'Busi U24EPR9',
                'merk' => 'Denso',
                'satuan' => 'pcs',
                'harga_beli' => 15000,
                'harga_jual' => 22000,
                'stok' => 0,
                'stok_minimal' => 15,
                'keterangan' => 'Busi standar untuk motor bebek & matic.',
            ],
            [
                'kode_sparepart' => 'SP-008',
                'kategori_id' => $kelistrikan->id,
                'nama_sparepart' => 'Aki MF GTZ5S',
                'merk' => 'GS Astra',
                'satuan' => 'pcs',
                'harga_beli' => 180000,
                'harga_jual' => 210000,
                'stok' => 0,
                'stok_minimal' => 3,
                'keterangan' => 'Aki kering motor matic & bebek.',
            ],
            [
                'kode_sparepart' => 'SP-009',
                'kategori_id' => $ban->id,
                'nama_sparepart' => 'Ban Luar Tubeless 80/90-14',
                'merk' => 'FDR',
                'satuan' => 'pcs',
                'harga_beli' => 150000,
                'harga_jual' => 185000,
                'stok' => 0,
                'stok_minimal' => 6,
                'keterangan' => 'Ban luar tubeless motor matic Honda/Yamaha.',
            ],
            [
                'kode_sparepart' => 'SP-010',
                'kategori_id' => $ban->id,
                'nama_sparepart' => 'Ban Dalam Bebek 2.50-17',
                'merk' => 'IRC',
                'satuan' => 'pcs',
                'harga_beli' => 32000,
                'harga_jual' => 40000,
                'stok' => 0,
                'stok_minimal' => 8,
                'keterangan' => 'Ban dalam motor bebek ukuran ring 17.',
            ],
        ];

        $parts = [];
        foreach ($sparepartsData as $data) {
            $parts[] = Sparepart::updateOrCreate(
                ['kode_sparepart' => $data['kode_sparepart']],
                $data
            );
        }

        // Clean existing transaction logs to avoid duplicate / messy historical data
        DB::table('barang_masuk')->delete();
        DB::table('barang_keluar')->delete();

        // 4. Run Chronological Simulation (Maret 2026 - Juni 2026)
        $startDate = Carbon::create(2026, 3, 1);
        $endDate = Carbon::create(2026, 6, 7);

        // First, purchase initial stock for all spareparts on March 1, 2026
        foreach ($parts as $part) {
            $qty = rand(30, 50);
            BarangMasuk::create([
                'sparepart_id' => $part->id,
                'jumlah' => $qty,
                'harga_beli' => $part->harga_beli,
                'harga_total' => $qty * $part->harga_beli,
                'tanggal' => '2026-03-01',
                'keterangan' => 'Pembelian stok awal operasional toko dari distributor resmi.',
            ]);
            $part->stok = $qty;
        }

        // Loop day-by-day starting from March 2, 2026
        $currentDate = $startDate->copy()->addDay();
        while ($currentDate->lessThanOrEqualTo($endDate)) {
            $dateString = $currentDate->toDateString();

            // 75% chance of transactions occurring on any given day
            if (rand(1, 100) <= 75) {
                // Simulating 1 to 5 sales transactions per day
                $numSales = rand(1, 5);

                for ($i = 0; $i < $numSales; $i++) {
                    // Select a random spare part
                    $partIndex = array_rand($parts);
                    $part = $parts[$partIndex];

                    // Sell 1 to 3 units
                    $sellQty = rand(1, 3);

                    // Check if stock is running low. If so, trigger automatic restock before selling.
                    if (($part->stok - $sellQty) <= $part->stok_minimal) {
                        $restockQty = rand(25, 45);
                        BarangMasuk::create([
                            'sparepart_id' => $part->id,
                            'jumlah' => $restockQty,
                            'harga_beli' => $part->harga_beli,
                            'harga_total' => $restockQty * $part->harga_beli,
                            'tanggal' => $dateString,
                            'keterangan' => 'Restok otomatis distributor karena sisa stok mendekati batas minimal.',
                        ]);
                        $part->stok += $restockQty;
                    }

                    // Create sales log
                    $keterangan = $this->getRandomSalesKeterangan($part);
                    BarangKeluar::create([
                        'sparepart_id' => $part->id,
                        'jumlah' => $sellQty,
                        'tanggal' => $dateString,
                        'keterangan' => $keterangan,
                    ]);
                    $part->stok -= $sellQty;
                    
                    // Sync array copy
                    $parts[$partIndex] = $part;
                }
            }

            $currentDate->addDay();
        }

        // Save final simulated stocks to spareparti table
        foreach ($parts as $part) {
            $part->save();
        }
    }

    /**
     * Generate logical sales descriptions based on sparepart type
     */
    private function getRandomSalesKeterangan(Sparepart $part): string
    {
        $desc = [
            'Penjualan retail langsung ke pelanggan.',
            'Pembelian eceran oleh pengendara umum.',
            'Keperluan servis rutin motor pelanggan.',
            'Pemasangan sparepart baru di bengkel.',
        ];

        $name = strtolower($part->nama_sparepart);

        if (str_contains($name, 'oli')) {
            $desc[] = 'Paket servis rutin + ganti oli mesin.';
            $desc[] = 'Ganti oli mesin motor matic konsumen.';
            $desc[] = 'Servis berkala dan kuras oli.';
        } elseif (str_contains($name, 'rem')) {
            $desc[] = 'Ganti kampas rem depan karena aus.';
            $desc[] = 'Servis pengereman dan ganti brake pad.';
            $desc[] = 'Keluhan rem bunyi dan penggantian kampas.';
        } elseif (str_contains($name, 'ban')) {
            $desc[] = 'Ganti ban baru karena ban lama gundul.';
            $desc[] = 'Pemasangan ban luar tubeless baru.';
            $desc[] = 'Tambal ban dan ganti ban dalam bocor.';
        } elseif (str_contains($name, 'v-belt') || str_contains($name, 'gear') || str_contains($name, 'roller')) {
            $desc[] = 'Ganti transmisi CVT / rantai motor berisik.';
            $desc[] = 'Servis CVT dan ganti part transmisi aus.';
            $desc[] = 'Ganti rantai dan gear set satu paket.';
        } elseif (str_contains($name, 'aki') || str_contains($name, 'busi')) {
            $desc[] = 'Ganti aki baru karena motor starter lemah.';
            $desc[] = 'Ganti busi motor brebet / susah hidup.';
        }

        return $desc[array_rand($desc)];
    }
}
