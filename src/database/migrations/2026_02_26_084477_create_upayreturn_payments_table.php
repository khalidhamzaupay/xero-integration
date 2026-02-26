<?php
//
//use Illuminate\Database\Migrations\Migration;
//use Illuminate\Database\Schema\Blueprint;
//use Illuminate\Support\Facades\Schema;
//
//return new class extends Migration
//{
//    public function up(): void
//    {
//        Schema::create('upayreturn_payments', function (Blueprint $table) {
//            $table->id();
//            $table->decimal('u_amount', 15, 4);
//            $table->date('u_date');
//            $table->string('u_reference')->nullable();
//            $table->unsignedBigInteger('u_refund_id');
//            $table->unsignedBigInteger('u_payment_method_id');
//            $table->unsignedBigInteger('u_merchant_id');
//            $table->unsignedBigInteger('u_customer_id');
//
//            $table->timestamps();
//            $table->softDeletes();
//        });
//    }
//
//    public function down(): void
//    {
//        Schema::dropIfExists('upayreturn_payments');
//    }
//};
