<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAddressToWarehouseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('warehouses', function (Blueprint $table) {
            $table->after('owner',function($table){
                $table->foreignId('province_id')->constrained();
                $table->foreignId('district_id')->constrained();
                $table->foreignId('sector_id')->constrained();
                $table->foreignId('cell_id')->constrained();
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
            $table->dropForeign('warehouses_province_id_foreign');
            $table->dropForeign('warehouses_district_id_foreign');
            $table->dropForeign('warehouses_sector_id_foreign');
            $table->dropForeign('warehouses_cell_id_foreign');
            $table->dropColumn('province_id');
            $table->dropColumn('district_id');
            $table->dropColumn('sector_id');
            $table->dropColumn('cell_id');
        });
    }
}
