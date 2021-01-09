<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowerUserPivotTable extends Migration
{
    public function up()
    {
        Schema::create('follower_user', function (Blueprint $table) {
            $table->unsignedBigInteger('follower_id');
            $table->foreign('follower_id', 'follower_id_fk_2948064')->references('id')->on('followers')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'user_id_fk_2948064')->references('id')->on('users')->onDelete('cascade');
        });
    }
}
