<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ViolationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('p_violations')->insert([
            ['p_category_id' => 1, 'name' => 'Memanjangkan/ mewarnai kuku', 'point' => 3],
            ['p_category_id' => 1, 'name' => 'Tidak memakai  seragam dan atribut lengkap', 'point' => 3],
            ['p_category_id' => 1, 'name' => 'Menggunakan aksesoris selain jam tangan', 'point' => 3],
            ['p_category_id' => 1, 'name' => 'Tidak menjaga kerapihan pakaian', 'point' => 3],
            ['p_category_id' => 1, 'name' => 'Tidak memakai ciput/ inner  hijab', 'point' => 3],
            ['p_category_id' => 1, 'name' => 'Tidak menghadiri kegiatan PHBI dan PHBN yang diselenggarakan sekolah', 'point' => 5],
            ['p_category_id' => 1, 'name' => 'Memakai dan membawa make up yang berlebihan kecuali sunscreen, lipbalm, parfum', 'point' => 5],
            ['p_category_id' => 1, 'name' => 'Terlambat tiba di sekolah ', 'point' => 5],
            ['p_category_id' => 1, 'name' => 'Meninggalkan pelajaran tanpa izin', 'point' => 5],
            ['p_category_id' => 2, 'name' => 'Tidak mengikuti upacara bendera', 'point' => 10],
            ['p_category_id' => 2, 'name' => 'Tidak mengikuti kultum dan kegiatan rutin lainnya', 'point' => 10],
            ['p_category_id' => 2, 'name' => 'Membawa dan bermain kartu di sekolah', 'point' => 10],
            ['p_category_id' => 2, 'name' => 'Tidak mengikuti minimal satu kegiatan ekstrakuler', 'point' => 15],
            ['p_category_id' => 2, 'name' => 'Tidak bisa menjaga sopan santun (berbicara kasar, mengejek dan menghina) di lingkungan sekolah', 'point' => 15],
            ['p_category_id' => 2, 'name' => 'Rambut tidak sesuai ketentuan ukuran 321/diwarnai', 'point' => 15],
            ['p_category_id' => 2, 'name' => 'Membawa teman yang bukan peserta didik SMKN 1 Talaga tanpa izin pihak keamanan', 'point' => 15],
            ['p_category_id' => 2, 'name' => 'Tidak masuk ke sekolah tanpa keterangan (Alpa)', 'point' => 15],
            ['p_category_id' => 2, 'name' => 'Mengaktifkan HP pada saat KBM (kecuali izin guru mapel)', 'point' => 15],
            ['p_category_id' => 2, 'name' => 'Menggunakan kendaraan dengan knalpot bising', 'point' => 20],
            ['p_category_id' => 2, 'name' => 'Melakukan tindakan vandalisme dan merusak fasilitas sekolah', 'point' => 20],
            ['p_category_id' => 2, 'name' => 'Masuk dan keluar sekolah tidak melalui pintu gerbang utama', 'point' => 20],
            ['p_category_id' => 2, 'name' => 'Main game online dilingkungan sekolah', 'point' => 25],
            ['p_category_id' => 2, 'name' => 'Terlibat dalam aktifitas politik praktis', 'point' => 25],
            ['p_category_id' => 3, 'name' => 'Mengakses dan menyimpan hal-hal berbentuk pornoaksi dan pornografi', 'point' => 30],
            ['p_category_id' => 3, 'name' => 'Merokok dan memperjual belikan rokok', 'point' => 30],
            ['p_category_id' => 3, 'name' => 'Melakukan provokasi (bolos, berkelahi, tawuran antar pelajar)', 'point' => 50],
            ['p_category_id' => 3, 'name' => 'Merusak barang milik warga sekolah', 'point' => 50],
            ['p_category_id' => 3, 'name' => 'Mempropagandakan komunitas yang tidak sehat', 'point' => 50],
            ['p_category_id' => 3, 'name' => 'Memakai tato/ tindik', 'point' => 50],
            ['p_category_id' => 3, 'name' => 'Mencederai atau melakukan tindakan kekerasan lain terhadap teman atau orang lain', 'point' => 50],
            ['p_category_id' => 3, 'name' => 'Melakukan pelecehan seksual berupa verbal maupun nonverbal', 'point' => 50],
            ['p_category_id' => 3, 'name' => 'Melakukan bullying baik secara fisik, verbal, maupun cyber bullying', 'point' => 50],
            ['p_category_id' => 3, 'name' => 'Memposting foto/ video asusila', 'point' => 75],
            ['p_category_id' => 3, 'name' => 'Membawa senjata tajam', 'point' => 75],
            ['p_category_id' => 3, 'name' => 'Terlibat dalam geng motor (ORMAS) atau kelompok yang tidak sehat', 'point' => 80],
            ['p_category_id' => 3, 'name' => 'Melakukan perbuatan asusila baik secara langsung maupun tidak langsung', 'point' => 100],
            ['p_category_id' => 3, 'name' => 'Menantang, mengancam dan menyakiti karyawan, guru dan kepala sekolah', 'point' => 100],
            ['p_category_id' => 3, 'name' => 'Membawa, mengedarkan, mengkonsumsi narkoba dan minuman keras', 'point' => 100],
            ['p_category_id' => 3, 'name' => 'Membawa senjata api', 'point' => 100],
            ['p_category_id' => 3, 'name' => 'Terlibat dalam perjudian dan pencurian', 'point' => 100],
            ['p_category_id' => 3, 'name' => 'Terlibat tawuran dengan sekolah lain', 'point' => 100],

        ]);
    }
}
