<?php

namespace Modules\Jobs\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class JobsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(JobIntentDatabaseSeeder::class);
        $this->call(JobStatusDatabaseSeeder::class);
    }
}
