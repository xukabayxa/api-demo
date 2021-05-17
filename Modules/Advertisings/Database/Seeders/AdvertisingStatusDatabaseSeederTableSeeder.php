<?php

namespace Modules\Advertisings\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AdvertisingStatusDatabaseSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('advertising_statuses')->truncate();

        DB::table('advertising_statuses')->insert([
            [
                'name' => 'open',
            ],
            [
                'name' => 'close',
            ],
        ]);
    }
}
