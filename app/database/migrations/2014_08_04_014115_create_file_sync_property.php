<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFileSyncProperty extends Migration
{
    public function up()
    {
        Schema::table('files', function(Blueprint $t){
            $t->integer('sync_server')
                ->default(0);
        });
    }


    public function down()
    {
        Schema::table('files', function(Blueprint $t){
            $t->dropColumn('sync_server');
        });
    }
}
