<?php

namespace Modules\Areas\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AreasDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('areas')->truncate();

        DB::table('areas')->insert([
            [
                'name' => 'Hà Nội',
                'code' => '01'
            ],
            [
                'name' => 'Hồ Chí Minh',
                'code' => '02'
            ]
        ]);
    }
}
