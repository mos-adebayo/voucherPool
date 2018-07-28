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
            $table->unsignedInteger('recipient_id');
            $table->date('expiry_date');
            $table->date('used_on')->nullable();
            $table->unsignedInteger('offer_id');
            $table->unsignedInteger('status_id');
            $table->timestamps();

            $table->foreign('recipient_id')->references('id')->on('recipients');
            $table->foreign('status_id')->references('id')->on('status');
            $table->foreign('offer_id')->references('id')->on('offers');

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
