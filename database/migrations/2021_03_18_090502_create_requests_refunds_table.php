<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestsRefundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests_refunds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('transaction_id')->nullable();
            $table->string('token_id')->nullable();
            $table->string('name');
            $table->string('iban');
            $table->string('swift_code');
            $table->string('address_1')->nullable();
            $table->string('address_2')->nullable();
            $table->string('address_3')->nullable();
            $table->double('amount');
            $table->tinyInteger('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requests_refunds');
    }
}
