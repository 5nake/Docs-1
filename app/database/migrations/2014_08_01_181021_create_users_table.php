<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    const TABLE_NAME = 'users';

    public function up()
    {
        Schema::create(self::TABLE_NAME, function(Blueprint $table) {
            $table->increments('id');
            $table->string('login',     255);
            $table->string('avatar',    255)
                ->nullable();
            $table->string('email',     255)
                ->nullable()
                ->unique();
            $table->string('password',  255)
                ->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->index('login');
        });
    }

    public function down()
    {
        Schema::drop(self::TABLE_NAME);
    }
}
