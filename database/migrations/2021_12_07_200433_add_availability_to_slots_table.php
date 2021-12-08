<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAvailabilityToSlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('slots', function (Blueprint $table) {
            $table->dropColumn('remaining');
            $table->dropForeign('slots_item_id_foreign');
            $table->dropColumn('item_id');
            $table->dropForeign('slots_unity_id_foreign');
            $table->dropColumn('unity_id');
            $table->after('size',function($table){
                $table->integer('price')->default(0);
                $table->boolean('taken')->default(false);
                $table->foreignId('category_id')->nullable()->constrained();
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
            $table->dropColumn('price');
            $table->dropColumn('taken');
            $table->dropForeign('slots_category_id_foreign');
            $table->dropColumn('category_id');
            $table->integer('remaining')->nullable();
            $table->foreignId('item_id')->nullable()->constrained();
            $table->foreignId('unity_id')->nullable()->constrained();
        });
    }
}
