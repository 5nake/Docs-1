<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration
{
    public function up()
    {
        DB::transaction(function(){
            Schema::create('tags', function(Blueprint $t){
                $t->increments('id');
                $t->string('title');
                $t->timestamps();
            });

            Schema::create('documents_tags', function(Blueprint $t){
                $t->increments('id');
                $t->integer('tag_id')->index();
                $t->integer('document_id')->index();
            });

            Schema::rename('files', 'documents');
        });
    }


    public function down()
    {
        DB::transaction(function() {
            Schema::drop('tags');
            Schema::drop('documents_tags');
            Schema::rename('documents', 'files');
        });
    }
}
