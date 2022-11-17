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
            'Adiksi', 'Depresi', 'Gangguan Kecemasan',
            'Gangguan Kepribadian', 'Gangguan Mood', 'Insecure',
            'Keluarga & Hubungan', 'Pekerjaan & Karir', 'Pengembangan Diri',
            'Penyakit yang diderita', 'Percintaan', 'Stres', 'Trauma'
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
