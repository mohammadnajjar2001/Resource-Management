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
            $table->string('name')->nullable(); // اسم المنتج
            $table->integer('package_count')->nullable(); // العدد بالطرد (يمكن أن يكون غير مطلوب)
            $table->decimal('unit_count', 10, 2)->nullable();
            $table->decimal('price_usd', 10, 2)->default(0); // سعر المنتج بالدولار
            $table->text('notes')->nullable(); // ملاحظات
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
