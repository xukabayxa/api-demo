<?php

namespace Modules\Advertisings\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AdvertisingIntentDatabaseSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('advertising_intents')->truncate();

        DB::table('advertising_intents')->insert([
            [
                'name' => 'search',
            ],
            [
                'name' => 'transfer',
            ],
            [
                'name' => 'sale',
            ],
        ]);
    }
}
