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
//        Schema::create('upaypayments', function (Blueprint $table) {
//            $table->id();
//            $table->unsignedBigInteger('payment_method_id');
//            $table->unsignedBigInteger('merchant_id');
//            $table->decimal('amount', 15, 4);
//            $table->date('date');
//            $table->string('reference')->nullable();
//            $table->timestamps();
//        });
//    }
//
//    public function down(): void
//    {
//        Schema::dropIfExists('upaypayments');
//    }
//};
