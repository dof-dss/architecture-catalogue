<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          Schema::table('users', function (Blueprint $table) {
              $table->string('password')->nullable()->change();
              $table->string('provider_name', 30)->nullable()->after('remember_token');
              $table->string('provider_id', 100)->nullable()->after('provider_name');
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
            $table->string('password')->nullable(false)->change();
            $table->dropColumn('provider_name');
            $table->dropColumn('provider_id');
        });
    }
}
