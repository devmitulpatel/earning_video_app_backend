<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChannelUserPivotTable extends Migration
{
    public function up()
    {
        Schema::create('channel_user', function (Blueprint $table) {
            $table->unsignedBigInteger('channel_id');
            $table->foreign('channel_id', 'channel_id_fk_2948170')->references('id')->on('channels')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'user_id_fk_2948170')->references('id')->on('users')->onDelete('cascade');
        });
    }
}
