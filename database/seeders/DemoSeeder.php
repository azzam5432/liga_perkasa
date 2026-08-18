<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Tim;
use App\Models\Peserta;
use App\Models\Lomba;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
         $faker = Faker::create('id_ID');

        for ($i = 1; $i <= 20; $i++) {
            User::create([
                'name' => $faker->name,
                'email' => 'panitia' . $i . '@example.com',
                'password' => Hash::make('password123'),
                'role' => 'panitia',
                'no_telp' => '08' . $faker->randomNumber(9, true),
                'jabatan' => $faker->randomElement(['Ketua Panitia', 'Sekretaris', 'Bendahara', 'Koordinator Acara', 'Koordinator Perlengkapan']),
                'instagram' => 'https://instagram.com/panitia' . $i,
                'facebook' => 'https://facebook.com/panitia' . $i,
                'bio' => $faker->sentence(10),
            ]);
        }

        for ($i = 1; $i <= 50; $i++) {
            $tim = Tim::create([
                'nama_tim' => 'Tim ' . $faker->company,
                'created_at' => $faker->dateTimeBetween('-6 months', 'now'),
            ]);

            Peserta::create([
                'id_tim' => $tim->id_tim,
                'ketua_peserta' => $faker->name,
                'nama_peserta' => $faker->name,
                'prodi' => $faker->randomElement(['Teknik Rekayasa Perangkat Lunak', 'Bisnis Digital', 'Teknik Rekayasa Manufaktur']),
                'no_telp' => '08' . $faker->randomNumber(9, true),
                'created_at' => $tim->created_at,
            ]);

            $jumlahAnggota = $faker->numberBetween(4, 7);
            for ($j = 1; $j <= $jumlahAnggota; $j++) {
                Peserta::create([
                    'id_tim' => $tim->id_tim,
                    'ketua_peserta' => null,
                    'nama_peserta' => $faker->name,
                    'prodi' => null,
                    'no_telp' => null,
                    'created_at' => $tim->created_at,
                ]);
            }
        }

        $lombaList = ['Lomba Karya Tulis Ilmiah', 'Lomba Inovasi Teknologi', 'Lomba Startup Digital', 'Lomba Desain Grafis', 'Lomba Fotografi'];
        foreach ($lombaList as $lomba) {
            Lomba::create([
                'nama_lomba' => $lomba,
                'kategori' => $faker->randomElement(['Akademik', 'Non-Akademik', 'Teknologi', 'Seni']),
                'tanggal_mulai' => $faker->dateTimeBetween('-3 months', 'now'),
                'tanggal_selesai' => $faker->dateTimeBetween('now', '+3 months'),
                'status' => $faker->randomElement(['open', 'draft', 'closed', 'selesai']),
                'deskripsi' => $faker->paragraph(3),
            ]);
        }
    }
}
