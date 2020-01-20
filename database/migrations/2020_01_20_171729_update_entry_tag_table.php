<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateEntryTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entry_tag', function (Blueprint $table) {
            $table->foreign('entry_id')
                ->references('id')
                ->on('entries')
                ->onDelete('cascade');
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
            $table->dropForeign('entry_tag_entry_id_foreign');
            $table->dropIndex('entry_tag_entry_id_foreign');
        });
    }
}
