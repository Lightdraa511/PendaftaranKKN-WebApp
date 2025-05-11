<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\Fakultas;
use App\Models\ProgramStudi;
use App\Models\Lokasi;
use App\Models\KuotaFakultas;
use App\Models\Pengaturan;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat admin
        Admin::create([
            'nama' => 'Admin KKNM',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin123'),
        ]);

        // Buat fakultas
        $fakultas = [
            ['nama_fakultas' => 'Teknik'],
            ['nama_fakultas' => 'Ekonomi'],
            ['nama_fakultas' => 'Hukum'],
            ['nama_fakultas' => 'Kedokteran'],
            ['nama_fakultas' => 'MIPA'],
            ['nama_fakultas' => 'FISIP'],
            ['nama_fakultas' => 'FIB'],
        ];

        foreach ($fakultas as $fak) {
            Fakultas::create($fak);
        }

        // Buat program studi
        $programStudi = [
            // Teknik
            ['fakultas_id' => 1, 'nama_program' => 'Teknik Informatika'],
            ['fakultas_id' => 1, 'nama_program' => 'Teknik Sipil'],
            ['fakultas_id' => 1, 'nama_program' => 'Teknik Elektro'],
            ['fakultas_id' => 1, 'nama_program' => 'Teknik Mesin'],
            // Ekonomi
            ['fakultas_id' => 2, 'nama_program' => 'Manajemen'],
            ['fakultas_id' => 2, 'nama_program' => 'Akuntansi'],
            ['fakultas_id' => 2, 'nama_program' => 'Ekonomi Pembangunan'],
            // Hukum
            ['fakultas_id' => 3, 'nama_program' => 'Ilmu Hukum'],
            // Kedokteran
            ['fakultas_id' => 4, 'nama_program' => 'Pendidikan Dokter'],
            ['fakultas_id' => 4, 'nama_program' => 'Keperawatan'],
            ['fakultas_id' => 4, 'nama_program' => 'Kesehatan Masyarakat'],
            // MIPA
            ['fakultas_id' => 5, 'nama_program' => 'Matematika'],
            ['fakultas_id' => 5, 'nama_program' => 'Fisika'],
            ['fakultas_id' => 5, 'nama_program' => 'Kimia'],
            ['fakultas_id' => 5, 'nama_program' => 'Biologi'],
            // FISIP
            ['fakultas_id' => 6, 'nama_program' => 'Ilmu Komunikasi'],
            ['fakultas_id' => 6, 'nama_program' => 'Ilmu Politik'],
            ['fakultas_id' => 6, 'nama_program' => 'Hubungan Internasional'],
            // FIB
            ['fakultas_id' => 7, 'nama_program' => 'Sastra Indonesia'],
            ['fakultas_id' => 7, 'nama_program' => 'Sastra Inggris'],
            ['fakultas_id' => 7, 'nama_program' => 'Sastra Jepang'],
        ];

        foreach ($programStudi as $prodi) {
            ProgramStudi::create($prodi);
        }

        // Buat lokasi
        $lokasi = [
            [
                'nama_lokasi' => 'Desa Sukamaju',
                'kecamatan' => 'Cianjur',
                'kabupaten' => 'Cianjur',
                'provinsi' => 'Jawa Barat',
                'deskripsi' => 'Lokasi KKN ini berfokus pada pengembangan pendidikan dan pemberdayaan ekonomi masyarakat desa. Mahasiswa akan berkolaborasi dengan warga untuk mengembangkan program literasi, pengelolaan UMKM lokal, dan digitalisasi administrasi desa.',
                'fokus_program' => 'Fokus pada pengembangan pendidikan dan pemberdayaan ekonomi masyarakat desa.',
                'koordinator' => 'Dr. Adi Prasetyo, M.Si.',
                'kontak_koordinator' => '0812-3456-7890',
                'status' => 'tersedia',
                'kuota_total' => 20,
                'kuota_terisi' => 0,
            ],
            [
                'nama_lokasi' => 'Desa Harapan Jaya',
                'kecamatan' => 'Padang Cermin',
                'kabupaten' => 'Pesawaran',
                'provinsi' => 'Lampung',
                'deskripsi' => 'Lokasi KKN ini berfokus pada pengembangan pariwisata dan pelestarian lingkungan. Mahasiswa akan berpartisipasi dalam program ekowisata, pendidikan lingkungan, dan pengembangan ekonomi kreatif berbasis potensi lokal.',
                'fokus_program' => 'Fokus pada program lingkungan dan pariwisata berkelanjutan.',
                'koordinator' => 'Dr. Maya Pratiwi, M.Si.',
                'kontak_koordinator' => '0812-3456-7891',
                'status' => 'tersedia',
                'kuota_total' => 15,
                'kuota_terisi' => 0,
            ],
            [
                'nama_lokasi' => 'Kelurahan Sejahtera',
                'kecamatan' => 'Lowokwaru',
                'kabupaten' => 'Kota Malang',
                'provinsi' => 'Jawa Timur',
                'deskripsi' => 'Lokasi KKN perkotaan yang berfokus pada pengembangan ekonomi digital dan literasi teknologi. Mahasiswa akan membantu pengembangan UMKM digital, pendidikan komputer untuk masyarakat, dan implementasi teknologi untuk pelayanan publik.',
                'fokus_program' => 'Program KKN perkotaan dengan fokus pada digitalisasi UMKM dan literasi digital.',
                'koordinator' => 'Dr. Budi Santoso, M.Kom.',
                'kontak_koordinator' => '0812-3456-7892',
                'status' => 'tersedia',
                'kuota_total' => 25,
                'kuota_terisi' => 0,
            ],
        ];

        foreach ($lokasi as $lok) {
            Lokasi::create($lok);
        }

        // Buat kuota fakultas untuk setiap lokasi
        $kuotaFakultas = [];

        // Lokasi 1: Desa Sukamaju
        $kuotaFakultas[] = ['lokasi_id' => 1, 'fakultas_id' => 1, 'kuota' => 5, 'terisi' => 0]; // Teknik
        $kuotaFakultas[] = ['lokasi_id' => 1, 'fakultas_id' => 2, 'kuota' => 4, 'terisi' => 0]; // Ekonomi
        $kuotaFakultas[] = ['lokasi_id' => 1, 'fakultas_id' => 3, 'kuota' => 3, 'terisi' => 0]; // Hukum
        $kuotaFakultas[] = ['lokasi_id' => 1, 'fakultas_id' => 4, 'kuota' => 2, 'terisi' => 0]; // Kedokteran
        $kuotaFakultas[] = ['lokasi_id' => 1, 'fakultas_id' => 5, 'kuota' => 3, 'terisi' => 0]; // MIPA
        $kuotaFakultas[] = ['lokasi_id' => 1, 'fakultas_id' => 6, 'kuota' => 2, 'terisi' => 0]; // FISIP
        $kuotaFakultas[] = ['lokasi_id' => 1, 'fakultas_id' => 7, 'kuota' => 1, 'terisi' => 0]; // FIB

        // Lokasi 2: Desa Harapan Jaya
        $kuotaFakultas[] = ['lokasi_id' => 2, 'fakultas_id' => 1, 'kuota' => 4, 'terisi' => 0]; // Teknik
        $kuotaFakultas[] = ['lokasi_id' => 2, 'fakultas_id' => 5, 'kuota' => 3, 'terisi' => 0]; // MIPA
        $kuotaFakultas[] = ['lokasi_id' => 2, 'fakultas_id' => 6, 'kuota' => 5, 'terisi' => 0]; // FISIP
        $kuotaFakultas[] = ['lokasi_id' => 2, 'fakultas_id' => 7, 'kuota' => 3, 'terisi' => 0]; // FIB

        // Lokasi 3: Kelurahan Sejahtera
        $kuotaFakultas[] = ['lokasi_id' => 3, 'fakultas_id' => 1, 'kuota' => 7, 'terisi' => 0]; // Teknik
        $kuotaFakultas[] = ['lokasi_id' => 3, 'fakultas_id' => 2, 'kuota' => 8, 'terisi' => 0]; // Ekonomi
        $kuotaFakultas[] = ['lokasi_id' => 3, 'fakultas_id' => 5, 'kuota' => 5, 'terisi' => 0]; // MIPA
        $kuotaFakultas[] = ['lokasi_id' => 3, 'fakultas_id' => 6, 'kuota' => 5, 'terisi' => 0]; // FISIP

        foreach ($kuotaFakultas as $kuota) {
            KuotaFakultas::create($kuota);
        }

        // Buat pengaturan
        Pengaturan::create([
            'biaya_pendaftaran' => 750000,
            'biaya_administrasi' => 10000,
            'tanggal_mulai_pendaftaran' => now(),
            'tanggal_selesai_pendaftaran' => now()->addDays(14),
            'tanggal_mulai_pelaksanaan' => now()->addMonth(),
            'tanggal_selesai_pelaksanaan' => now()->addMonth()->addDays(14),
            'judul_pengumuman' => 'Pendaftaran KKNM Dibuka',
            'isi_pengumuman' => 'Pendaftaran KKNM periode ' . date('Y') . ' telah dibuka. Mahasiswa dapat mendaftar mulai tanggal ' . now()->format('d F Y') . ' melalui sistem pendaftaran online. Jadwal pembekalan KKNM telah ditetapkan pada tanggal ' . now()->addMonth()->format('d F Y') . ' dan terdapat penambahan kuota untuk beberapa lokasi KKNM.',
            'tampilkan_pengumuman' => true,
            'pendaftaran_aktif' => true,
        ]);
    }
}
