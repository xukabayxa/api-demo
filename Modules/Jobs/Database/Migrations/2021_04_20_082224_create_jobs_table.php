<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('short_content')->nullable();
            $table->text('content');
            $table->integer('area_id');
            $table->string('address');
            $table->integer('salary')->nullable();
            $table->tinyInteger('intent_id');
            $table->tinyInteger('type');
            $table->integer('job_category_id');
            $table->integer('status_id');
            $table->date('expiration_date')->nullable();
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
        Schema::dropIfExists('jobs');
    }
}
