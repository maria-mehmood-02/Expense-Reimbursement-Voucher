<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supervisors', function (Blueprint $table) {
            $table->string('sup_email',20);
            $table->foreign('sup_email')->references('email')->on('users')->onDelete('cascade');
            $table->string('emp_email',20);
            $table->foreign('emp_email')->references('email')->on('users')->onDelete('cascade');
            $table->integer('voucher_number');
            $table->foreign('voucher_number')->references('voucher_number')->on('vouchers')->onDelete('cascade');
            // $table->id();
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('supervisors');
    }
};
