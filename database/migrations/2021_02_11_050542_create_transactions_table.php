<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('number_sequence');
            $table->foreignId('prefix_id');
            $table->string('invoice_number');
            $table->foreignId('product_id');
            $table->foreignId('user_id');
            $table->string('cashier_name');
            $table->integer('quantity');
            $table->integer('price');
            $table->integer('total');
            $table->integer('payment')->nullable();
            $table->integer('change')->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
