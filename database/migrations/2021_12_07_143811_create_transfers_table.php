<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from')->constrained('warehouses');
            $table->foreignId('to')->constrained('warehouses');
            $table->foreignId('slot_id')->constrained('slots');
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('owner')->constrained('users');
            $table->foreignId('incharge')->nullable()->constrained('users');
            $table->date('until');
            $table->integer('quantity');
            $table->enum('status', ['Pending', 'Approved','Denied'])->default('Pending');
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
        Schema::dropIfExists('transfers');
    }
}
