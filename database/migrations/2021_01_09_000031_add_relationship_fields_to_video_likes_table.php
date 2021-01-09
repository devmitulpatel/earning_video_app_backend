<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToVideoLikesTable extends Migration
{
    public function up()
    {
        Schema::table('video_likes', function (Blueprint $table) {
            $table->unsignedBigInteger('video_id')->nullable();
            $table->foreign('video_id', 'video_fk_2948057')->references('id')->on('video_lists');
        });
    }
}
