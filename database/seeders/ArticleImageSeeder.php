<?php

namespace Database\Seeders;

use App\Models\ArticleImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleImageSeeder extends Seeder
{

    public function run(): void
    {
        ArticleImage::create([
            'article_id' => 1,
            'image_path' => 'articles/1/community.png',
            'sort_order' => 1,
        ]);
    }
}
