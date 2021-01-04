<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->timestamp('invoice_date');
            $table->timestamp('due_date')->nullable();
            $table->string('product');
            $table->string('department');
            $table->string('deduction')->nullable();
            $table->decimal('vat_rate');
            $table->decimal('vat_value');
            $table->decimal('total');
            $table->char('status',1)->default('0');//0-> not paid , 1=> paid , 2 => partially paid
            $table->text('note')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users');
            $table->softDeletes();
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
        Schema::dropIfExists('invoices');
    }
}
