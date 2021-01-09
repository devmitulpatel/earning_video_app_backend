<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoinMastersTable extends Migration
{
    public function up()
    {
        Schema::create('coin_masters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('coin_amount')->nullable();
            $table->string('type_transaction')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
