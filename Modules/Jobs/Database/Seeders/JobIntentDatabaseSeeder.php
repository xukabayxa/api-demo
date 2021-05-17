<?php

namespace Modules\Jobs\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class JobIntentDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::table('job_intents')->truncate();

        DB::table('job_intents')->insert([
            [
                'name' => 'search',
            ],
            [
                'name' => 'recruitment',
            ]
        ]);
    }
}
