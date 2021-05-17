<?php

namespace Modules\Motels\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MotelIntentDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('motel_intents')->truncate();

      DB::table('motel_intents')->insert([
          [
              'name' => 'search',
          ],
          [
              'name' => 'transfer',
          ],
          [
              'name' => 'pairing',
          ],
          [
              'name' => 'sale',
          ],
      ]);
    }
}
