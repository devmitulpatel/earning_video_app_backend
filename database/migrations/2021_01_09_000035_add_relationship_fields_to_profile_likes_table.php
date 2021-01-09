<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToProfileLikesTable extends Migration
{
    public function up()
    {
        Schema::table('profile_likes', function (Blueprint $table) {
            $table->unsignedBigInteger('profile_by_id')->nullable();
            $table->foreign('profile_by_id', 'profile_by_fk_2948049')->references('id')->on('users');
        });
    }
}
