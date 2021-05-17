<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(\Modules\Customers\Database\Seeders\CustomerTypeDatabaseSeeder::class);
        $this->call(\Modules\Areas\Database\Seeders\AreasDatabaseSeeder::class);
        $this->call(\Modules\Schools\Database\Seeders\SchoolsDatabaseSeeder::class);
    }
}
