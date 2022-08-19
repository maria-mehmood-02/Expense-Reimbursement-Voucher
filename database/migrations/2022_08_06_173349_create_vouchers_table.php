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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->integer('voucher_number', 7);
            $table->string('emp_email', 20);
            $table->foreign('emp_email')->references('email')->on('users')->onDelete('cascade');
            $table->date('voucher_date');
            $table->text('voucher_description',150);
            $table->double('amount');
            $table->double('advance_payment')->default(0.00);
            $table->string('status',10);
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
        Schema::dropIfExists('vouchers');
    }
};
