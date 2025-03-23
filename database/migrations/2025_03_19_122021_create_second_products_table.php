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
        Schema::create('second_products', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // اسم المنتج
            $table->decimal('price', 10, 2); // سعر المنتج
            $table->integer('stock')->default(0); // الكمية المتوفرة
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
        Schema::dropIfExists('second_products');
    }
};
