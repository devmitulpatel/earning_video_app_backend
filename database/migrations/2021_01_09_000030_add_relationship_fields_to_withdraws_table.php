<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToWithdrawsTable extends Migration
{
    public function up()
    {
        Schema::table('withdraws', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_2948155')->references('id')->on('users');
            $table->unsignedBigInteger('approved_by_id')->nullable();
            $table->foreign('approved_by_id', 'approved_by_fk_2948159')->references('id')->on('users');
        });
    }
}
