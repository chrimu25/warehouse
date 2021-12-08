<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUnityToProductsTable extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->after('owner_id',function($table){
                $table->foreignId('category_id')->nullable()->constrained();
                $table->foreignId('unity_id')->nullable()->constrained();
            }); 
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign('products_category_id_foreign');
            $table->dropColumn('category_id');
            $table->dropForeign('products_unity_id_foreign');
            $table->dropColumn('unity_id');
        });
    }
}
