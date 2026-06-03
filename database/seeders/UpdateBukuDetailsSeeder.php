<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateBukuDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $booksData = [
            'Atomic Habits' => [
                'isbn' => '9780735211292',
                'deskripsi' => 'Atomic Habits merupakan buku pengembangan diri yang menjelaskan bahwa perubahan kecil yang dilakukan secara konsisten dapat menghasilkan dampak besar dalam kehidupan. James Clear membahas cara membangun kebiasaan baik, menghilangkan kebiasaan buruk, serta pentingnya sistem dan identitas diri dalam proses perubahan. Buku ini memberikan panduan praktis untuk meningkatkan kualitas hidup melalui kebiasaan sederhana yang dilakukan secara berkelanjutan.'
            ],
            'Ayat-Ayat Cinta' => [
                'isbn' => '9789793210605',
                'deskripsi' => 'Ayat-Ayat Cinta adalah novel religi yang mengisahkan kehidupan Fahri, seorang mahasiswa Indonesia di Mesir, yang menghadapi berbagai persoalan cinta, pengorbanan, dan nilai-nilai keislaman. Novel ini tidak hanya menghadirkan kisah romantis, tetapi juga menggambarkan konflik batin serta pentingnya menjaga prinsip hidup dalam menghadapi berbagai ujian kehidupan.'
            ],
            'Bumi Manusia' => [
                'isbn' => '9789799731234',
                'deskripsi' => 'Bumi Manusia merupakan novel berlatar masa kolonial Hindia Belanda yang mengisahkan perjuangan Minke, seorang pribumi terpelajar, dalam menghadapi diskriminasi rasial dan ketidakadilan sosial. Novel ini menyoroti persoalan cinta, pendidikan, nasionalisme, serta perjuangan untuk memperoleh martabat dan hak di tengah sistem kolonial yang menindas.'
            ],
            'Cantik Itu Luka' => [
                'isbn' => '9789799103130',
                'deskripsi' => 'Cantik Itu Luka adalah novel yang memadukan unsur sejarah, tragedi, realisme magis, dan kritik sosial. Kisah ini berpusat pada Dewi Ayu dan keluarganya yang hidup di tengah berbagai penderitaan dan perubahan sosial-politik di Indonesia. Novel ini dikenal karena gaya penceritaannya yang unik dan sarat makna.'
            ],
            'Clean Code' => [
                'isbn' => '9780132350884',
                'deskripsi' => 'Clean Code merupakan buku yang membahas prinsip-prinsip penulisan kode program yang baik, efisien, dan mudah dipelihara. Buku ini menekankan pentingnya menulis kode yang tidak hanya berfungsi, tetapi juga mudah dipahami, sehingga dapat meningkatkan kualitas perangkat lunak dan profesionalisme seorang programmer.'
            ],
            'Filosofi Teras' => [
                'isbn' => '9786024125189',
                'deskripsi' => 'Filosofi Teras merupakan buku yang memperkenalkan filsafat Stoisisme dalam konteks kehidupan modern. Buku ini membahas bagaimana seseorang dapat mengelola emosi, menghadapi masalah secara rasional, serta membangun ketenangan batin melalui penerapan prinsip-prinsip Stoik dalam kehidupan sehari-hari.'
            ],
            'Gadis Kretek' => [
                'isbn' => '9789792285529',
                'deskripsi' => 'Gadis Kretek merupakan novel yang mengangkat kisah cinta, keluarga, dan sejarah industri kretek di Indonesia. Melalui alur yang bergerak antara masa lalu dan masa kini, novel ini menggambarkan persaingan bisnis, hubungan antargenerasi, serta keterkaitan antara sejarah pribadi dan sejarah bangsa.'
            ],
            'Gajah Mada' => [
                'isbn' => null, // Berbeda tiap seri
                'deskripsi' => 'Gajah Mada merupakan novel sejarah yang mengangkat perjalanan hidup Mahapatih Gajah Mada dalam mewujudkan kejayaan Majapahit. Novel ini menggambarkan strategi politik, peperangan, konflik kekuasaan, serta pengorbanan seorang tokoh besar dalam sejarah Nusantara.'
            ],
            'Hujan' => [
                'isbn' => '9786020324784',
                'deskripsi' => 'Hujan adalah novel fiksi ilmiah yang mengisahkan kehidupan Lail, seorang perempuan yang harus menghadapi kehilangan besar akibat bencana yang mengubah dunia. Novel ini memadukan unsur teknologi masa depan dengan persoalan emosional seperti kehilangan, cinta, dan harapan.'
            ],
            'Laskar Pelangi' => [
                'isbn' => '9789793062792',
                'deskripsi' => 'Laskar Pelangi merupakan novel yang menceritakan perjuangan sepuluh anak di Belitung dalam memperoleh pendidikan di tengah keterbatasan ekonomi. Novel ini menggambarkan semangat belajar, persahabatan, dan perjuangan untuk meraih mimpi melalui pendidikan.'
            ],
            'Laut Bercerita' => [
                'isbn' => '9786024246945',
                'deskripsi' => 'Laut Bercerita merupakan novel yang mengangkat kisah para aktivis mahasiswa pada masa Orde Baru yang mengalami penangkapan dan penghilangan paksa. Novel ini menggambarkan perjuangan, idealisme, serta penderitaan keluarga yang harus menghadapi kehilangan tanpa kepastian.'
            ],
            'Perahu Kertas' => [
                'isbn' => '9786028811675',
                'deskripsi' => 'Perahu Kertas adalah novel yang mengisahkan perjalanan hidup Kugy dan Keenan dalam mencari jati diri, cinta, dan impian. Novel ini menampilkan kisah tentang persahabatan, pilihan hidup, serta keberanian untuk mengikuti cita-cita.'
            ],
            'Pulang' => [
                'isbn' => '9786020822129',
                'deskripsi' => 'Pulang merupakan novel yang menceritakan perjalanan hidup Bujang di tengah dunia penuh konflik, kekuasaan, dan loyalitas. Novel ini tidak hanya menghadirkan kisah aksi, tetapi juga menggambarkan pencarian makna keluarga dan arti “pulang” dalam kehidupan seseorang.'
            ],
            'Ronggeng Dukuh Paruk' => [
                'isbn' => '9789792208845',
                'deskripsi' => 'Ronggeng Dukuh Paruk merupakan novel yang mengisahkan kehidupan Srintil, seorang perempuan desa yang menjadi ronggeng dan harus menghadapi konflik antara tradisi, cinta, dan perubahan sosial-politik. Novel ini kaya akan nilai budaya serta kritik sosial.'
            ],
            'Sapiens: Riwayat Singkat Umat Manusia' => [
                'isbn' => '9780062316097',
                'deskripsi' => 'Sapiens merupakan buku nonfiksi yang membahas sejarah perkembangan manusia dari masa prasejarah hingga era modern. Buku ini menjelaskan bagaimana Homo sapiens berkembang melalui berbagai revolusi besar yang membentuk peradaban manusia.'
            ],
            'Sebuah Seni untuk Bersikap Bodo Amat' => [
                'isbn' => '9786024526986',
                'deskripsi' => 'Sebuah Seni untuk Bersikap Bodo Amat merupakan buku pengembangan diri yang mengajarkan bahwa seseorang tidak perlu memedulikan semua hal, melainkan fokus pada hal-hal yang benar-benar penting. Buku ini membahas cara menerima keterbatasan dan menjalani hidup dengan lebih realistis.'
            ],
            'The Pragmatic Programmer' => [
                'isbn' => '9780135957059',
                'deskripsi' => 'The Pragmatic Programmer merupakan buku yang membahas prinsip-prinsip praktis dalam pengembangan perangkat lunak agar seorang programmer dapat bekerja lebih efektif dan profesional. Buku ini menekankan pentingnya pola pikir adaptif, kemampuan memecahkan masalah, dan kebiasaan menulis kode yang berkualitas.'
            ],
        ];

        foreach ($booksData as $judul => $info) {
            DB::table('bukus')
                ->where('judul', $judul)
                ->update([
                    'isbn' => $info['isbn'],
                    'deskripsi' => $info['deskripsi'],
                    'updated_at' => now()
                ]);
        }
    }
}
