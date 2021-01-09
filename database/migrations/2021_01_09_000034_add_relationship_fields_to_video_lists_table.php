<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToVideoListsTable extends Migration
{
    public function up()
    {
        Schema::table('video_lists', function (Blueprint $table) {
            $table->unsignedBigInteger('categories_id')->nullable();
            $table->foreign('categories_id', 'categories_fk_2947943')->references('id')->on('categories');
            $table->unsignedBigInteger('event_id')->nullable();
            $table->foreign('event_id', 'event_fk_2948175')->references('id')->on('events');
            $table->unsignedBigInteger('channel_id')->nullable();
            $table->foreign('channel_id', 'channel_fk_2948176')->references('id')->on('channels');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_2948177')->references('id')->on('users');
        });
    }
}
