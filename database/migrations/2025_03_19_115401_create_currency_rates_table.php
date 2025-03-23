<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currency_rates', function (Blueprint $table) {
            $table->id();
            $table->decimal('usd_to_try', 10,2);  // سعر الصرف من الدولار إلى الليرة التركية
            $table->decimal('usd_to_syp', 10);  // سعر الصرف من الدولار إلى الليرة السورية
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
        Schema::dropIfExists('currency_rates');
    }
};
