<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $smartphone = "Smartphone";
        $laptop = "Laptop";
        $flashdisk = "Flashdisk";

        DB::table("categories")->insert([
            [
                "name" => $smartphone,
                "slug" => Str::slug($smartphone),
            ],
            [
                "name" => $laptop,
                "slug" => Str::slug($laptop),
            ],
            [
                "name" => $flashdisk,
                "slug" => Str::slug($flashdisk),
            ],
        ]);
    }
}
