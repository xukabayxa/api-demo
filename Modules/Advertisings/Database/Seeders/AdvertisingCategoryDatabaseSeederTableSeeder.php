<?php

namespace Modules\Advertisings\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdvertisingCategoryDatabaseSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('advertising_categories')->truncate();

        DB::table('advertising_categories')->insert([
            [
                'name' => 'tài liệu - giáo trình',
                'slug' => Str::slug('tài liệu, giáo trình'),
                'parent_id' => 0
            ],
            [
                'name' => 'tài liệu chuyên ngành CNTT',
                'slug' => Str::slug('tài liệu chuyên ngành CNTT'),
                'parent_id' => 1,
            ],
            [
                'name' => 'tài liệu chuyên ngành cơ khí',
                'slug' => Str::slug('tài liệu chuyên ngành Cơ khí'),
                'parent_id' => 1,
            ],
            [
                'name' => 'điện thoại phụ kiện',
                'slug' => Str::slug('điện thoại phụ kiện'),
                'parent_id' => 4,
            ],
            [
                'name' => 'thiết bị điện tử',
                'slug' => Str::slug('thiết bị điện tử'),
                'parent_id' => 0,
            ],
            [
                'name' => 'ô tô - xe máy - xe đạp',
                'slug' => Str::slug('ô tô - xe máy - xe đạp'),
                'parent_id' => 0,
            ],
        ]);
    }
}
