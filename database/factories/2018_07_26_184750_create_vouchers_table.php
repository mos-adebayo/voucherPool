<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 100)->unique();
            $table->unsignedInteger('recipientId');
            $table->date('expiryDate');
            $table->date('usedOn');
            $table->unsignedInteger('offerId');
            $table->unsignedInteger('statusId');
            $table->timestamps();

            $table->foreign('recipientId')->references('id')->on('recipients');
            $table->foreign('statusId')->references('id')->on('status');
            $table->foreign('offerId')->references('id')->on('offers');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vouchers');
    }
}
