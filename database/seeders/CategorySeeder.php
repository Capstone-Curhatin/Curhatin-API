<?php

namespace Database\Seeders;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $categories = [
            'Asmara', 'Percintaan', 'Rumah Tangga', 'Keluarga',
            'Finansial', 'Mental Health', 'Insecure', 'Tempat Kerja', 'Bisnis',
            'Rahasia', 'Aib', 'Kejahatan', 'Penyakit Hati', 'Kebencian','Sekolah',
            'Perkuliahan', 'Mimpi', 'Harapan', 'Bosan Hidup', 'Random', 'Penyimpangan', 'Penyakit'
        ];

        foreach ($categories as $category){
            DB::table('categories')->insert([
                'name' => $category,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }


    }
}
