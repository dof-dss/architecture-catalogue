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
          Schema::table('entry_tag', function (Blueprint $table) {
              $table->string('provider_name');
              $table->string('provider_id');
          });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('entry_tag', function (Blueprint $table) {
            $table->dropColumn('provider_name');
            $table->dropColumn('provider_id');
        });
    }
}
