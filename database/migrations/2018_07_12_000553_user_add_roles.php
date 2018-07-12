<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserAddRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('permission_signatory')->default(false);
            $table->boolean('permission_approver')->default(false);
            $table->boolean('permission_admin')->default(false);
            $table->boolean('permission_view')->default(1);
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
            $table->dropColumn('permission_signatory');
            $table->dropColumn('permission_approver');
            $table->dropColumn('permission_admin');
            $table->dropColumn('permission_view');
        });
    }
}
