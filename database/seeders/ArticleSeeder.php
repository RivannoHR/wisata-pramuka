<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{

    public function run(): void
    {
        Article::create([
            'title' => 'Solusi Lingkungan Pulau Pramuka, Minyak Jelantah Disulap Jadi Lilin dan Sabun Ramah Lingkungan',
            'content' => 'Dari minyak jelantah menjadi peluang baru di Pulau Pramuka.
                Apa yang dulu dianggap limbah, kini disulap menjadi produk ramah lingkungan: sabun dan lilin aromaterapi. Inovasi ini lahir dari Hibah PkM Dikti 2025, diketuai oleh Dr. Maryani, S.Kom, MMSI., CDMS, CBDMP (Sistem Informasi) bersama dua rekan dosen, Dr. Siswantini, S.E., Ak., M.I.Kom (Ilmu Komunikasi) dan Titi Indahyani, S.Sn., M.M., Ph.D. (Desain Interior), serta mahasiswa BINUS University. Bersama komunitas lokal, mereka menghadirkan solusi sederhana namun berdampak nyata bagi masyarakat.

                Selama dua hari pelatihan (18-19 Agustus 2025), masyarakat Pulau Pramuka belajar langsung membuat sabun, lilin aromaterapi, hingga kemasan ramah lingkungan. Tidak hanya itu, para pemuda Karang Taruna juga dibekali strategi promosi digital untuk memperkuat branding pariwisata daerah. Antusiasme warga begitu terasa, berharap produk-produk ini bisa menjadi souvenir khas yang mengangkat identitas Pulau Pramuka.

                Lebih dari sekadar pelatihan, program ini menumbuhkan kesadaran lingkungan, membuka peluang wirausaha baru, sekaligus mendukung Sustainable Development Goals (SDGs) dalam pendidikan, pertumbuhan ekonomi, dan kolaborasi berkelanjutan. Dari Pulau Pramuka, kita belajar bahwa inovasi bisa berawal dari hal sederhana ketika perguruan tinggi, komunitas, dan masyarakat melangkah bersama.
            ',
            'category' => 'lingkungan'
        ]);
    }
}
