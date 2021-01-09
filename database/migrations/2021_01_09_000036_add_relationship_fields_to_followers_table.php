<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToFollowersTable extends Migration
{
    public function up()
    {
        Schema::table('followers', function (Blueprint $table) {
            $table->unsignedBigInteger('host_id')->nullable();
            $table->foreign('host_id', 'host_fk_2948063')->references('id')->on('users');
        });
    }
}
