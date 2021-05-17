<?php

namespace Modules\Schools\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SchoolsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('school_types')->truncate();
        DB::table('school_types')->insert([
            [
                'name' => 'highschool',
            ],
            [
                'name' => 'university',
            ],
        ]);

        DB::table('schools')->truncate();
        DB::table('schools')->insert([
            [
                'name' => 'Đại học Công Nghiệp Hà Nội',
                'code' => 'HAUI',
                'area_id' => 1,
                'school_type_id' => 2
            ],
            [
                'name' => 'Đại học Kinh Tế Quốc Dân',
                'code' => 'NEU',
                'area_id' => 1,
                'school_type_id' => 2
            ],
            [
                'name' => 'Học viện Kỹ Thuật Mật Mã',
                'code' => 'KMA',
                'area_id' => 1,
                'school_type_id' => 2
            ],
            [
                'name' => 'Đại học Dược Hà Nội',
                'code' => 'HUP',
                'area_id' => 1,
                'school_type_id' => 2
            ],
            [
                'name' => 'THPT Thường Tín',
                'code' => 'THPT TT',
                'area_id' => 1,
                'school_type_id' => 1
            ],
        ]);
    }
}
