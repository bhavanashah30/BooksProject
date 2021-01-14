<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Details', function (Blueprint $table) {
            $table->foreign('book_id', 'details_table_book_id_foreign')
                ->references('id')->on('Books')->onDelete('RESTRICT')
                ->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Details', function (Blueprint $table) {
            $table->dropForeign('details_table_book_id_foreign');
        });
    }
}
