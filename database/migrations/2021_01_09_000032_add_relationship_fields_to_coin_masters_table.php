<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCoinMastersTable extends Migration
{
    public function up()
    {
        Schema::table('coin_masters', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_2948086')->references('id')->on('users');
            $table->unsignedBigInteger('task_id')->nullable();
            $table->foreign('task_id', 'task_fk_2948137')->references('id')->on('coin_tasks');
        });
    }
}
