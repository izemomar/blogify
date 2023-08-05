<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Api\V1\Article::factory()
            ->count(10)
            ->hasMetas(3)
            ->create();
    }
}
