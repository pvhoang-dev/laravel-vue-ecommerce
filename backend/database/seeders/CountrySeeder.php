<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $VNCitys = [
            "HN" => 'Hà Nội',
            "HCM" => 'Hồ Chí Minh',
            "HD" => 'Hải Dương',
            "HY" => 'Hưng Yên',
            "ND" => 'Nam Định',
        ];
        $countries = [
            ['code' => 'vn', 'name' => 'Việt Nam', 'states' => json_encode($VNCitys)],
            ['code' => 'cn', 'name' => 'China', 'states' => null],
            ['code' => 'usa', 'name' => 'USA', 'states' => null],
            ['code' => 'ger', 'name' => 'Germany', 'states' => null],
        ];
        Country::insert($countries);
    }
}
