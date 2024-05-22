<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGuaranteeLetterIdToRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->unsignedBigInteger('guarantee_letter_id')->after('payment_method')->nullable();
        });
    }

    public function down()
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropColumn('guarantee_letter_id');
        });
    }
}
