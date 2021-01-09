<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWithdrawsTable extends Migration
{
    public function up()
    {
        Schema::create('withdraws', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('coin_amount')->nullable();
            $table->decimal('rate', 15, 2)->nullable();
            $table->decimal('inr_amount', 15, 2)->nullable();
            $table->string('status')->nullable();
            $table->string('transaction')->nullable();
            $table->string('transaction_data')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
