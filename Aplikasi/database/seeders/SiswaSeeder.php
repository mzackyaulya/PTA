<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menggunakan lokalisasi Indonesia (id_ID) agar data nama/alamat sesuai Indonesia
        $faker = Faker::create('id_ID');

        // Lakukan perulangan sebanyak 20 kali
        for ($i = 1; $i <= 20; $i++) {
            
            // 1. Generate UUID untuk User terlebih dahulu
            $userId = (string) Str::uuid();
            
            // 2. Generate NISN 10 digit (Harus unik karena di migrasi ada rule ->unique())
            $nisnSiswa = $faker->unique()->numerify('##########');

            // 3. Insert data ke tabel Users (Sekarang sudah lengkap dengan NISN)
            User::create([
                'id' => $userId, 
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'nisn' => $nisnSiswa, // KUNCI UTAMA: Ditambahkan di sini agar bisa digunakan login
                'nip' => null, // Karena ini siswa, NIP dikosongkan
                'password' => Hash::make('password123'), // Password default semua siswa untuk login
            ]);

            // 4. Insert data ke tabel Siswas (Berelasi dengan user_id di atas)
            DB::table('siswas')->insert([
                'id' => (string) Str::uuid(),
                'user_id' => $userId, // Menghubungkan ke user yang baru dibuat
                'nis' => $faker->numerify('##########'), // Ini NIS lokal sekolah (boleh disamakan/dibedakan dengan NISN)
                'jenis_kelamin' => $faker->randomElement(['Laki-laki', 'Perempuan']),
                'tempat_lahir' => $faker->city,
                'tanggal_lahir' => $faker->date('Y-m-d', '-16 years'), // Kisaran umur siswa 16 tahun
                'kewarganegaraan' => 'WNI',
                'agama' => $faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Khonghucu']),
                'alamat' => $faker->address,
                'nik' => $faker->numerify('################'), // 16 digit NIK
                'nohp' => $faker->phoneNumber,
                'dusun' => 'Dusun ' . $faker->word,
                'kecamatan' => $faker->city,
                'kelurahan' => $faker->streetName,
                'rt' => $faker->numerify('0##'),
                'rw' => $faker->numerify('0##'),
                'kodepos' => $faker->postcode,
                'jenis_tinggal' => $faker->randomElement(['Tinggal dengan Orang Tua', 'Kos', 'Asrama']),
                'alat_transportasi' => $faker->randomElement(['Sepeda Motor', 'Angkutan Umum', 'Jalan Kaki']),

                // Data Orang Tua (Ayah)
                'nama_ayah' => $faker->name('male'),
                'tanggal_lahir_ayah' => $faker->date('Y-m-d', '-45 years'),
                'nik_ayah' => $faker->numerify('################'),
                'pendidikan_ayah' => $faker->randomElement(['SD', 'SMP', 'SMA', 'S1', 'S2']),
                'pekerjaan_ayah' => $faker->jobTitle,
                'penghasilan_ayah' => $faker->randomElement(['Rp 1.000.000 - Rp 3.000.000', 'Rp 3.000.000 - Rp 5.000.000', '> Rp 5.000.000']),

                // Data Orang Tua (Ibu)
                'nama_ibu' => $faker->name('female'),
                'tanggal_lahir_ibu' => $faker->date('Y-m-d', '-42 years'),
                'nik_ibu' => $faker->numerify('################'),
                'pendidikan_ibu' => $faker->randomElement(['SD', 'SMP', 'SMA', 'S1']),
                'pekerjaan_ibu' => $faker->randomElement(['Ibu Rumah Tangga', 'PNS', 'Karyawan Swasta']),
                'penghasilan_ibu' => $faker->randomElement(['Tidak Berpenghasilan', 'Rp 1.000.000 - Rp 3.000.000']),

                // Data Wali (Diisi default strip jika tidak ada)
                'nama_wali' => '-',
                'tanggal_lahir_wali' => $faker->date('Y-m-d', '-40 years'),
                'nik_wali' => '-',
                'pendidikan_wali' => '-',
                'pekerjaan_wali' => '-',

                // Data Tambahan Sekolah
                'no_akta_lahir' => $faker->numerify('AKTA-#####'),
                'jurusan' => $faker->randomElement(['RPL', 'TKJ', 'Multimedia']),
                'kebutuhan_khusus' => 'Tidak Ada',
                'asal_sekolah' => 'SMPN 1 ' . $faker->city,
                'anakke' => (string) $faker->numberBetween(1, 4),
                'no_kk' => $faker->numerify('################'),
                'berat_badan' => (string) $faker->numberBetween(45, 75),
                'tinggi_badan' => (string) $faker->numberBetween(150, 180),
                'lingkar_kepala' => (string) $faker->numberBetween(52, 58),
                'jumlah_saudara' => (string) $faker->numberBetween(0, 4),
                'jarak_rumah' => $faker->numberBetween(1, 10) . ' KM',
                'foto' => null, 
                'tahun_masuk' => 2025,
                'status_siswa' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}