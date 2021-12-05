<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveCategoryToSlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('slots', function (Blueprint $table) {
            $table->dropForeign('slots_category_id_foreign');
            $table->after('remaining',function($table){
                $table->foreignId('item_id')->nullable()->constrained();
            });
            $table->dropColumn('category_id');
        });
        Schema::table('warehouses', function (Blueprint $table) {
            $table->dropForeign('warehouses_category_id_foreign');
            $table->dropColumn('category_id');
            $table->after('type',function($table){
                $table->foreignId('item_id')->nullable()->constrained();
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
        Schema::table('slots', function (Blueprint $table) {
            $table->after('remaining',function($table){
                $table->foreignId('category_id')->nullable()->constrained();
            });
            $table->dropForeign('slots_item_id_foreign');
            $table->dropColumn('item_id');
        });

        Schema::table('warehouses', function (Blueprint $table) {
            $table->dropForeign('warehouses_item_id_foreign');
            $table->dropColumn('item_id');
            $table->after('type',function($table){
                $table->foreignId('category_id')->nullable()->constrained();
            });
        });
    }
}
