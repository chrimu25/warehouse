<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToWarehousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_warehouse_id_foreign');
            $table->dropColumn('warehouse_id');
        });
        Schema::table('warehouses', function (Blueprint $table) {
            $table->after('owner',function($table){
                $table->foreignId('user_id')->nullable()->constrained();
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
        });
        Schema::table('users', function (Blueprint $table) {
            $table->after('role',function($table){
                $table->foreignId('warehouse_id')->nullable()->constrained();
            });
        });
    }
}
