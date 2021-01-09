<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoinTasksTable extends Migration
{
    public function up()
    {
        Schema::create('coin_tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->longText('description')->nullable();
            $table->integer('coin_earn')->nullable();
            $table->string('single_task')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
