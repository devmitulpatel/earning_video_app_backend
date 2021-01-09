<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToVideoCommentsTable extends Migration
{
    public function up()
    {
        Schema::table('video_comments', function (Blueprint $table) {
            $table->unsignedBigInteger('video_id')->nullable();
            $table->foreign('video_id', 'video_fk_2948066')->references('id')->on('video_lists');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_2948067')->references('id')->on('users');
            $table->unsignedBigInteger('replay_to_id')->nullable();
            $table->foreign('replay_to_id', 'replay_to_fk_2948068')->references('id')->on('users');
        });
    }
}
