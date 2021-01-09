<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfileLikeUserPivotTable extends Migration
{
    public function up()
    {
        Schema::create('profile_like_user', function (Blueprint $table) {
            $table->unsignedBigInteger('profile_like_id');
            $table->foreign('profile_like_id', 'profile_like_id_fk_2948062')->references('id')->on('profile_likes')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'user_id_fk_2948062')->references('id')->on('users')->onDelete('cascade');
        });
    }
}
