<?php

namespace Database\Seeders;

use App\Models\ExerciseTemplate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExcerciseTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ExerciseTemplate::insert([
            [
                'name' => 'ベンチプレス',
                'category' => '胸',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'スクワット',
                'category' => '脚',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'デッドリフト',
                'category' => '背中',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
