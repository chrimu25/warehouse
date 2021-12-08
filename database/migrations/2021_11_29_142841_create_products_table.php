<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('quantity');
            $table->foreignId('owner_id')->comment('owner of item')->constrained('users');
            $table->foreignId('category_id')->constrained();
            $table->foreignId('unity_id')->constrained();
            $table->foreignId('warehouse_id')->constrained();
            $table->foreignId('incharge')->nullable()->comment('person to make insert')->constrained('users');
            $table->integer('duration')->comment('duration in days');
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
        Schema::dropIfExists('products');
    }
}
