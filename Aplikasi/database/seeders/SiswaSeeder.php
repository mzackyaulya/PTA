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
        $faker = Faker::create('id_ID');

        for ($i = 1; $i <= 50; $i++) {
            
            $userId = (string) Str::uuid();
            
            $nisnSiswa = $faker->unique()->numerify('##########');

            $namaSiswa = $faker->firstName . ' ' . $faker->lastName;

            User::create([
                'id' => $userId, 
                'name' => $namaSiswa,
                'email' => $faker->unique()->safeEmail,
                'nisn' => $nisnSiswa, 
                'nip' => null, 
                'password' => Hash::make('password123'), 
            ]);

            $alamatPalembang = 'Jl. ' . $faker->streetName . ' No. ' . $faker->buildingNumber . ', Palembang, Sumatera Selatan';

            $nisSiswa4Digit = str_pad($i, 4, '0', STR_PAD_LEFT); 

            $kebutuhanKhusus = $faker->randomElement(['IYA', 'TIDAK']);

            $jurusanSekolah = $faker->randomElement(['IPA', 'IPS']);

            DB::table('siswas')->insert([
                'id' => (string) Str::uuid(),
                'user_id' => $userId, 
                'nis' => $nisSiswa4Digit, 
                'jenis_kelamin' => $faker->randomElement(['Laki-laki', 'Perempuan']),
                'tempat_lahir' => 'Palembang',
                'tanggal_lahir' => $faker->date('Y-m-d', '-16 years'), 
                'kewarganegaraan' => 'WNI',
                'agama' => 'Islam', 
                'alamat' => $alamatPalembang,
                'nik' => $faker->numerify('################'), 
                'nohp' => $faker->phoneNumber,
                'dusun' => 'Lorong ' . $faker->word,
                'kecamatan' => $faker->randomElement(['Ilir Timur I', 'Ilir Timur II', 'Sako', 'Sujakarami', 'Plaju', 'Seberang Ulu I']), 
                'kelurahan' => $faker->streetName,
                'rt' => $faker->numerify('0##'),
                'rw' => $faker->numerify('0##'),
                'kodepos' => $faker->numerify('30###'), 
                'jenis_tinggal' => $faker->randomElement(['Tinggal dengan Orang Tua', 'Kos', 'Asrama']),
                'alat_transportasi' => $faker->randomElement(['Sepeda Motor', 'Angkutan Umum', 'Jalan Kaki']),

                // Data Orang Tua (Ayah)
                'nama_ayah' => $faker->firstName('male') . ' ' . $faker->lastName,
                'tanggal_lahir_ayah' => $faker->date('Y-m-d', '-45 years'),
                'nik_ayah' => $faker->numerify('################'),
                'pendidikan_ayah' => $faker->randomElement(['SD', 'SMP', 'SMA', 'S1', 'S2']),
                'pekerjaan_ayah' => $faker->jobTitle,
                'penghasilan_ayah' => $faker->randomElement(['Rp 1.000.000 - Rp 3.000.000', 'Rp 3.000.000 - Rp 5.000.000', '> Rp 5.000.000']),

                // Data Orang Tua (Ibu)
                'nama_ibu' => $faker->firstName('female') . ' ' . $faker->lastName,
                'tanggal_lahir_ibu' => $faker->date('Y-m-d', '-42 years'),
                'nik_ibu' => $faker->numerify('################'),
                'pendidikan_ibu' => $faker->randomElement(['SD', 'SMP', 'SMA', 'S1']),
                'pekerjaan_ibu' => $faker->randomElement(['Ibu Rumah Tangga', 'PNS', 'Karyawan Swasta']),
                'penghasilan_ibu' => $faker->randomElement(['Tidak Berpenghasilan', 'Rp 1.000.000 - Rp 3.000.000']),

                // Data Wali
                'nama_wali' => '-',
                'tanggal_lahir_wali' => $faker->date('Y-m-d', '-40 years'),
                'nik_wali' => '-',
                'pendidikan_wali' => '-',
                'pekerjaan_wali' => '-',

                // Data Tambahan Sekolah
                'no_akta_lahir' => $faker->numerify('AKTA-#####'),
                'jurusan' => $jurusanSekolah,
                'kebutuhan_khusus' => $kebutuhanKhusus,
                'asal_sekolah' => 'SMP Negeri di Palembang',
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