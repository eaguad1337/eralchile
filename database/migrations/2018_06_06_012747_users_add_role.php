<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UsersAddRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string("role")->default("normal");

            if (Schema::hasColumn("users", "is_signatory")) {
                $table->dropColumn("is_signatory");
            }

            if (Schema::hasColumn("users", "is_admin")) {
                $table->dropColumn("is_admin");
            }
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
            $table->dropColumn("role");
        });
    }
}
