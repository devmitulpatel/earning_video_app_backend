<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserVideoLikePivotTable extends Migration
{
    public function up()
    {
        Schema::create('user_video_like', function (Blueprint $table) {
            $table->unsignedBigInteger('video_like_id');
            $table->foreign('video_like_id', 'video_like_id_fk_2948058')->references('id')->on('video_likes')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'user_id_fk_2948058')->references('id')->on('users')->onDelete('cascade');
        });
    }
}
