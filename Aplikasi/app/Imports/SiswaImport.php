<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Siswa;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class SiswaImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        DB::beginTransaction();

        try {
            $user = User::create([
                'name'     => $row['nama'],
                'nisn'     => $row['nisn'],
                'email'    => $row['email'],
                'password' => Hash::make($row['password'] ?? 'siswa123'),
                'role'     => 'siswa',
            ]);

            $penghasilanAyah = isset($row['penghasilan_ayah']) ? str_replace('.', '', $row['penghasilan_ayah']) : '0';
            $penghasilanIbu  = isset($row['penghasilan_ibu']) ? str_replace('.', '', $row['penghasilan_ibu']) : '0';

            Siswa::create([
                'user_id'            => $user->id,
                'nis'                => $row['nis'],
                'jenis_kelamin'      => $row['jenis_kelamin'],
                'tempat_lahir'       => $row['tempat_lahir'] ?? '',
                'tanggal_lahir'      => $row['tanggal_lahir'], // Format di excel harus YYYY-MM-DD
                'kewarganegaraan'    => $row['kewarganegaraan'] ?? 'WNI',
                'agama'              => $row['agama'],
                'alamat'             => $row['alamat'] ?? '',
                'nik'                => $row['nik'] ?? '',
                'nohp'               => $row['nohp'] ?? '',
                'dusun'              => $row['dusun'] ?? '',
                'kecamatan'          => $row['kecamatan'] ?? '',
                'kelurahan'          => $row['kelurahan'] ?? '',
                'rt'                 => $row['rt'] ?? '',
                'rw'                 => $row['rw'] ?? '',
                'kodepos'            => $row['kodepos'] ?? '',
                'jenis_tinggal'      => $row['jenis_tinggal'] ?? '',
                'alat_transportasi'  => $row['alat_transportasi'] ?? '',
                
                // Data Ayah
                'nama_ayah'          => $row['nama_ayah'] ?? '',
                'tanggal_lahir_ayah' => $row['tanggal_lahir_ayah'] ?? null,
                'nik_ayah'           => $row['nik_ayah'] ?? '',
                'pendidikan_ayah'    => $row['pendidikan_ayah'] ?? '',
                'pekerjaan_ayah'     => $row['pekerjaan_ayah'] ?? '',
                'penghasilan_ayah'   => $penghasilanAyah,

                // Data Ibu
                'nama_ibu'           => $row['nama_ibu'] ?? '',
                'tanggal_lahir_ibu'  => $row['tanggal_lahir_ibu'] ?? null,
                'nik_ibu'            => $row['nik_ibu'] ?? '',
                'pendidikan_ibu'     => $row['pendidikan_ibu'] ?? '',
                'pekerjaan_ibu'      => $row['pekerjaan_ibu'] ?? '',
                'penghasilan_ibu'    => $penghasilanIbu,

                // Data Wali
                'nama_wali'          => $row['nama_wali'] ?? '-',
                'tanggal_lahir_wali' => $row['tanggal_lahir_wali'] ?? null,
                'nik_wali'           => $row['nik_wali'] ?? '-',
                'pendidikan_wali'    => $row['pendidikan_wali'] ?? '-',
                'pekerjaan_wali'     => $row['pekerjaan_wali'] ?? '-',

                // Data Tambahan
                'no_akta_lahir'      => $row['no_akta_lahir'] ?? '',
                'kebutuhan_khusus'   => $row['kebutuhan_khusus'] ?? 'TIDAK',
                'jurusan'            => $row['jurusan'], // IPA / IPS
                'asal_sekolah'       => $row['asal_sekolah'] ?? '',
                'anakke'             => $row['anakke'] ?? '1',
                'no_kk'              => $row['no_kk'] ?? '',
                'berat_badan'        => $row['berat_badan'] ?? '',
                'tinggi_badan'       => $row['tinggi_badan'] ?? '',
                'lingkar_kepala'     => $row['lingkar_kepala'] ?? '',
                'jumlah_saudara'     => $row['jumlah_saudara'] ?? '0',
                'jarak_rumah'        => $row['jarak_rumah'] ?? '',
                'tahun_masuk'        => $row['tahun_masuk'],
                'status_siswa'       => $row['status_siswa'] ?? 'aktif',
                'foto'               => null, 
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return null;
    }

    /**
     * Validasi data Excel sebelum diinsert ke Database
     */
    public function rules(): array
    {
        return [
            'nama' => 'required|string|max:255',
            'nisn' => 'required|digits:10|unique:users,nisn',
            'nis' => 'required|digits:4|unique:siswas,nis',
            'email' => 'required|email|unique:users,email',
            'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan,Laki-laki',
            'agama' => 'required|string',
            'jurusan' => 'required|in:IPA,IPS',
            'tahun_masuk' => 'required',
        ];
    }
}