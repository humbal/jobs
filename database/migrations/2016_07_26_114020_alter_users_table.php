<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $users) {
            $users->tinyInteger('is_admin')->after('remember_token');
            $users->string('verification_code')->after('is_admin');
	    $users->tinyInteger('status')->after('verification_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $users) {
            $users->dropColumn('is_admin');
            $users->dropColumn('verification_code');
	    $users->dropColumn('status');
        });
    }
}
