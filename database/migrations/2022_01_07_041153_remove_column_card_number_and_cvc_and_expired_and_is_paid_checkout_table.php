<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveColumnCardNumberAndCvcAndExpiredAndIsPaidCheckoutTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('checkouts', function (Blueprint $table) {
            //
            $table->dropColumn(['card_number', 'cvc', 'expired', 'is_paid']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('checkouts', function (Blueprint $table) {
            //
            $table->string('card_number')->nullable();
            $table->string('cvc')->nullable();
            $table->date('expired')->nullable();
            $table->boolean('is_paid')->default(false);
        });
    }
}
