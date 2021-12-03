<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPictureToWarehouseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('warehouses', function (Blueprint $table) {
            $table->after('active',function($table){
                $table->foreignId('user_id')->constrained();
                $table->string('picture')->nullable(); 
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('warehouses', function (Blueprint $table) {
            $table->dropForeign('warehouses_user_id_foreign');
            $table->dropColumn('user_id');
            $table->dropColumn('picture');
        });
    }
}
