<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Kriteria;
use App\Models\Cosplayer;
use App\Models\Penilaian;
use App\Services\SawService;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed User Admin
        User::create([
            'username' => 'admin',
            'nama_lengkap' => 'Septian Rahmat Hidayat',
            'email' => 'admin@kalselunite.id',
            'password' => Hash::make('admin123'),
        ]);

        // 2. Seed Kriteria
        $kriteriaData = [
            [
                'kode_kriteria' => 'C1',
                'nama_kriteria' => 'Detail Kostum',
                'bobot' => 0.30,
                'jenis' => 'benefit',
            ],
            [
                'kode_kriteria' => 'C2',
                'nama_kriteria' => 'Aksi Panggung',
                'bobot' => 0.25,
                'jenis' => 'benefit',
            ],
            [
                'kode_kriteria' => 'C3',
                'nama_kriteria' => 'Make Up/Rias Wajah',
                'bobot' => 0.20,
                'jenis' => 'benefit',
            ],
            [
                'kode_kriteria' => 'C4',
                'nama_kriteria' => 'Penjiwaan Karakter',
                'bobot' => 0.25,
                'jenis' => 'benefit',
            ],
        ];

        $kriteriaModels = [];
        foreach ($kriteriaData as $k) {
            $kriteriaModels[$k['kode_kriteria']] = Kriteria::create($k);
        }

        // 3. Seed 20 Cosplayers & Nilai Juri
        $cosplayers = [
            ['no' => 'P01', 'nama' => 'Rian Hidayat', 'karakter' => 'Kamado Tanjiro', 'series' => 'Kimetsu no Yaiba', 'c1' => 25, 'c2' => 25, 'c3' => 25, 'c4' => 25],
            ['no' => 'P02', 'nama' => 'Aditya Pratama', 'karakter' => 'Gojō Satoru', 'series' => 'Jujutsu Kaisen', 'c1' => 24, 'c2' => 23, 'c3' => 22, 'c4' => 24],
            ['no' => 'P03', 'nama' => 'Fajar Santoso', 'karakter' => 'Monkey D. Luffy', 'series' => 'One Piece', 'c1' => 23, 'c2' => 24, 'c3' => 23, 'c4' => 22],
            ['no' => 'P04', 'nama' => 'Dimas Wicaksono', 'karakter' => 'Roronoa Zoro', 'series' => 'One Piece', 'c1' => 22, 'c2' => 22, 'c3' => 24, 'c4' => 23],
            ['no' => 'P05', 'nama' => 'Bayu Nugroho', 'karakter' => 'Uzumaki Naruto', 'series' => 'Naruto Shippuden', 'c1' => 24, 'c2' => 21, 'c3' => 23, 'c4' => 24],
            ['no' => 'P06', 'nama' => 'Gilang Ramadhan', 'karakter' => 'Eren Yeager', 'series' => 'Attack on Titan', 'c1' => 21, 'c2' => 24, 'c3' => 22, 'c4' => 23],
            ['no' => 'P07', 'nama' => 'Bintang Kusuma', 'karakter' => 'Levi Ackerman', 'series' => 'Attack on Titan', 'c1' => 23, 'c2' => 22, 'c3' => 21, 'c4' => 24],
            ['no' => 'P08', 'nama' => 'Hendra Saputra', 'karakter' => 'Sasuke Uchiha', 'series' => 'Naruto Shippuden', 'c1' => 22, 'c2' => 23, 'c3' => 23, 'c4' => 21],
            ['no' => 'P09', 'nama' => 'Indra Lesmana', 'karakter' => 'Ichigo Kurosaki', 'series' => 'Bleach', 'c1' => 24, 'c2' => 24, 'c3' => 20, 'c4' => 22],
            ['no' => 'P10', 'nama' => 'Yoga Arianto', 'karakter' => 'Zhongli', 'series' => 'Genshin Impact', 'c1' => 20, 'c2' => 22, 'c3' => 24, 'c4' => 24],
            ['no' => 'P11', 'nama' => 'Rizky Maulana', 'karakter' => 'Raiden Shogun', 'series' => 'Genshin Impact', 'c1' => 23, 'c2' => 21, 'c3' => 22, 'c4' => 23],
            ['no' => 'P12', 'nama' => 'Ahmad Fauzi', 'karakter' => 'Megumi Fushiguro', 'series' => 'Jujutsu Kaisen', 'c1' => 21, 'c2' => 23, 'c3' => 24, 'c4' => 20],
            ['no' => 'P13', 'nama' => 'Dwi Cahyo', 'karakter' => 'Killua Zoldyck', 'series' => 'Hunter x Hunter', 'c1' => 22, 'c2' => 24, 'c3' => 21, 'c4' => 22],
            ['no' => 'P14', 'nama' => 'Agus Wahyudi', 'karakter' => 'Kakashi Hatake', 'series' => 'Naruto Shippuden', 'c1' => 20, 'c2' => 21, 'c3' => 23, 'c4' => 22],
            ['no' => 'P15', 'nama' => 'Satria Wibowo', 'karakter' => 'Rengoku Kyojuro', 'series' => 'Kimetsu no Yaiba', 'c1' => 24, 'c2' => 20, 'c3' => 22, 'c4' => 21],
            ['no' => 'P16', 'nama' => 'Taufik Rahman', 'karakter' => 'Denji (Chainsaw Man)', 'series' => 'Chainsaw Man', 'c1' => 19, 'c2' => 23, 'c3' => 21, 'c4' => 24],
            ['no' => 'P17', 'nama' => 'Rio Ferdian', 'karakter' => 'Aki Hayakawa', 'series' => 'Chainsaw Man', 'c1' => 22, 'c2' => 20, 'c3' => 24, 'c4' => 19],
            ['no' => 'P18', 'nama' => 'Bagus Setiawan', 'karakter' => 'Son Goku', 'series' => 'Dragon Ball Super', 'c1' => 21, 'c2' => 22, 'c3' => 20, 'c4' => 23],
            ['no' => 'P19', 'nama' => 'Eko Prasetyo', 'karakter' => 'Trafalgar Law', 'series' => 'One Piece', 'c1' => 18, 'c2' => 21, 'c3' => 22, 'c4' => 21],
            ['no' => 'P20', 'nama' => 'Wahyu Utomo', 'karakter' => 'Saitama', 'series' => 'One Punch Man', 'c1' => 20, 'c2' => 19, 'c3' => 18, 'c4' => 22],
        ];

        foreach ($cosplayers as $c) {
            $createdCoser = Cosplayer::create([
                'no_peserta' => $c['no'],
                'nama_peserta' => $c['nama'],
                'nama_karakter' => $c['karakter'],
                'asal_series' => $c['series'],
            ]);

            // Insert penilaian
            Penilaian::create([
                'id_cosplayer' => $createdCoser->id_cosplayer,
                'id_kriteria' => $kriteriaModels['C1']->id_kriteria,
                'nilai' => $c['c1'],
            ]);
            Penilaian::create([
                'id_cosplayer' => $createdCoser->id_cosplayer,
                'id_kriteria' => $kriteriaModels['C2']->id_kriteria,
                'nilai' => $c['c2'],
            ]);
            Penilaian::create([
                'id_cosplayer' => $createdCoser->id_cosplayer,
                'id_kriteria' => $kriteriaModels['C3']->id_kriteria,
                'nilai' => $c['c3'],
            ]);
            Penilaian::create([
                'id_cosplayer' => $createdCoser->id_cosplayer,
                'id_kriteria' => $kriteriaModels['C4']->id_kriteria,
                'nilai' => $c['c4'],
            ]);
        }

        // 4. Kalkulasi awal SAW
        $sawService = new SawService();
        $sawService->calculate(true);
    }
}
