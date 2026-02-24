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
//        Schema::table('upaycustomer_payments', function (Blueprint $table) {
//            $table->unsignedBigInteger('customer_id')->nullable()->after('invoice_id');
//            $table->unsignedBigInteger('payment_id')->nullable()->after('customer_id');
//        });
//    }
//
//    public function down(): void
//    {
//        Schema::table('upaycustomer_payments', function (Blueprint $table) {
//            $table->dropColumn(['customer_id', 'payment_id']);
//        });
//    }
//};
