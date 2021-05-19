<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountsHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discounts_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('order_id');
            $table->foreignId('discount_id');
            $table->tinyInteger('payment')->default(\App\Helpers\Constant::DISCOUNT_PAYMENT['Pending']);
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
        Schema::dropIfExists('discounts_history');
    }
}
