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
                $table->bigIncrements('id');
                $table->string('invoice_number', 50);//رقم الفاتورة
                $table->date('invoice_Date')->nullable();// تاريخ الفاتورة
                $table->date('Due_date')->nullable();// تاريخ الاستحقاق
                $table->string('product', 50);//المنتجات
                $table->bigInteger( 'section_id' )->unsigned();
                //العلاقة بين الفاتورة والقسم ومن جدول الأقسام حيجيبلي من id  الاسم 
                $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
                $table->decimal('Amount_collection',8,2)->nullable();;
                $table->decimal('Amount_Commission',8,2);
                $table->decimal('Discount',8,2);
                $table->decimal('Value_VAT',8,2);//قيمة الضريبة
                $table->string('Rate_VAT', 999);//نسبة الضريبة 
                $table->decimal('Total',8,2);// الكلي
                $table->string('Status', 50);// الحالة
                $table->integer('Value_Status');// وكأنه id للحالات المدفوعة وغيرها، لتساعد في البحث 
                $table->text('note')->nullable();
                $table->date('Payment_Date')->nullable();// تاريخ الدفع 
                $table->softDeletes();// عملية الأرشفة
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
