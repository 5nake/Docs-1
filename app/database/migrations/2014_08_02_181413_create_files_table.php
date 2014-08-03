<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    public function up()
    {
        Schema::create('files', function($t){
            $t->increments('id');
            $t->integer('user_id');
            $t->string('title');
            $t->integer('permissions');
            $t->string('path');
            $t->string('token');
            $t->string('mime');
            $t->string('size');
            $t->string('preview')
              ->nullable();

            $t->timestamps();
            $t->index('token');
            $t->index('user_id');
        });
    }

    public function down()
    {
        Schema::drop('files');
    }
}
