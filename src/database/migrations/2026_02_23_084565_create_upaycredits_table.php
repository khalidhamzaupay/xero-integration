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
//        Schema::create('upaycredits', function (Blueprint $table) {
//            $table->id();
//            $table->string('type')->nullable();
//            $table->unsignedBigInteger('contact_id');
//            $table->date('date');
//            $table->string('status')->default('AUTHORISED');
//            $table->string('reference')->nullable();
//            $table->decimal('amount', 15, 4);
//            $table->unsignedBigInteger('merchant_id');
//            $table->timestamps();
//        });
//    }
//
//    public function down(): void
//    {
//        Schema::dropIfExists('upaycredits');
//    }
//};
