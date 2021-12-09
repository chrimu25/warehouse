<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategoryToTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transfers', function (Blueprint $table) {
            $table->after('product_id',function($table){
                $table->foreignId('category_id')->nullable()->constrained();
                $table->foreignId('unity_id')->nullable()->constrained();
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
        Schema::table('transfers', function (Blueprint $table) {
            $table->dropForeign('transfers_unity_id_foreign');
            $table->dropColumn('unity_id');
            $table->dropForeign('transfers_category_id_foreign');
            $table->dropColumn('category_id');
        });
    }
}
