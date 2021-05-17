<?php

namespace Modules\Customers\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CustomerTypeDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('student_types')->truncate();

        DB::table('student_types')->insert([
            [
                'name' => 'student_highschool'
            ],
            [
                'name' => 'student_university'
            ]
        ]);
    }
}
