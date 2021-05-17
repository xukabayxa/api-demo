<?php

namespace Modules\Jobs\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class JobStatusDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::table('job_statuses')->truncate();

        DB::table('job_statuses')->insert([
            [
                'name' => 'open',
            ],
            [
                'name' => 'close',
            ]
        ]);
    }
}
