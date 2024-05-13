<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_id')->nullable();
            $table->string('name');
            $table->string('honorific');
            $table->string('designation');
            $table->string('company_name');
            $table->string('email');
            $table->string('address');
            $table->string('country')->nullable();
            $table->string('phone');
            $table->string('fax')->nullable();
            $table->enum('currency',['USD', 'IDR'])->default('IDR');
            $table->boolean('invitation_letter')->default(false);
            $table->boolean('guarantee_letter')->default(false);
            $table->bigInteger('total_amount')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('payment_session_id')->nullable();
            $table->longtext('payment_body')->nullable();
            $table->longtext('payment_signature')->nullable();
            $table->timestamp('payment_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registrations');
    }
}
