<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoinTaskUserPivotTable extends Migration
{
    public function up()
    {
        Schema::create('coin_task_user', function (Blueprint $table) {
            $table->unsignedBigInteger('coin_task_id');
            $table->foreign('coin_task_id', 'coin_task_id_fk_2948127')->references('id')->on('coin_tasks')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'user_id_fk_2948127')->references('id')->on('users')->onDelete('cascade');
        });
    }
}
