<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('purchase_no')->unique();
            $table->unsignedBigInteger('supplier_id');
            $table->foreign('supplier_id')->references('id')->on('suppliers');
            $table->unsignedBigInteger('warehouse_id');
            $table->foreign('warehouse_id')->references('id')->on('warehouses');
            $table->float('item'); 
            $table->float('total_qty'); 
            $table->double('total_discount'); 
            $table->double('total_tax'); 
            $table->double('total_cost'); 
            $table->double('total_tax_rate')->nullable(); 
            $table->double('order_tax')->nullable(); 
            $table->double('order_discount')->nullable(); 
            $table->double('shipping_cost')->nullable(); 
            $table->double('grand_total'); 
            $table->double('paid_amount');
            $table->enum('purchase_status',['1','2','3','4'])->comment="1=Recived,2=Partial,3=Pending,4=Orderd"; 
            $table->enum('payment_status',['1','2'])->comment="1=Paid,2=Due"; 
            $table->string('document')->nullable();
            $table->text('note')->nullable();
            $table->enum('status', ['1','2'])->default(1)->comment="1=active,2=inactive";
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
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
        Schema::dropIfExists('purchases');
    }
}
