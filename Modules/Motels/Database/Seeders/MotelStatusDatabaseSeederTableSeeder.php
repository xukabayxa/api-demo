<?php

namespace Modules\Motels\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MotelStatusDatabaseSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('motel_statuses')->truncate();
        DB::table('motel_statuses')->insert([
            [
                'name' => 'open',
            ],
            [
                'name' => 'close',
            ]
        ]);

    }
}
