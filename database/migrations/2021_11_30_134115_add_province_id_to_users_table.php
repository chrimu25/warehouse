<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProvinceIdToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('province');
            $table->dropColumn('district');
            $table->dropColumn('sector');
            $table->dropColumn('cell');
            $table->after('company',function($table){
                $table->foreignId('province_id')->nullable()->constrained();
                $table->foreignId('district_id')->nullable()->constrained();
                $table->foreignId('sector_id')->nullable()->constrained();
                $table->foreignId('cell_id')->nullable()->constrained();
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_province_id_foreign');
            $table->dropForeign('users_district_id_foreign');
            $table->dropForeign('users_sector_id_foreign');
            $table->dropForeign('users_cell_id_foreign');
            $table->dropColumn('province_id');
            $table->dropColumn('district_id');
            $table->dropColumn('sector_id');
            $table->dropColumn('cell_id');
        });
    }
}
