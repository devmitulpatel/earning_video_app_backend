<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagVideoListPivotTable extends Migration
{
    public function up()
    {
        Schema::create('tag_video_list', function (Blueprint $table) {
            $table->unsignedBigInteger('video_list_id');
            $table->foreign('video_list_id', 'video_list_id_fk_2947942')->references('id')->on('video_lists')->onDelete('cascade');
            $table->unsignedBigInteger('tag_id');
            $table->foreign('tag_id', 'tag_id_fk_2947942')->references('id')->on('tags')->onDelete('cascade');
        });
    }
}
