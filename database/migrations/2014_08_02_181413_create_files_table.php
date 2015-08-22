<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateFilesTable
 */
class CreateFilesTable extends Migration
{
    public function up()
    {
        Schema::create('files', function(Blueprint $t) {
            $t->increments('id');
            $t->integer('user_id')->index();
            $t->string('title');
            $t->integer('permissions');
            $t->string('path');
            $t->string('token')->index();
            $t->string('mime');
            $t->bigInteger('size');
            $t->string('preview')->nullable();
            $t->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('files');
    }
}
