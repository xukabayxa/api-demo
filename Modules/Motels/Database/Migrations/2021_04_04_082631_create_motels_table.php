<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMotelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('motels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('short_content')->nullable();
            $table->text('content');
            $table->integer('area_id');
            $table->integer('intent_id');
            $table->string('address')->nullable();
            $table->integer('price')->nullable();
            $table->morphs('creatable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('motels');
    }
}
