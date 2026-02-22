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
//        Schema::create('upaycustomers', function (Blueprint $table) {
//            $table->id();
//            $table->string('name')->nullable();
//            $table->string('first_name')->nullable();
//            $table->string('last_name')->nullable();
//            $table->string('email')->nullable();
//            $table->string('status')->nullable();
//
//            $table->string('address_1')->nullable();
//            $table->string('city')->nullable();
//            $table->string('region')->nullable();
//            $table->string('country')->nullable();
//            $table->string('postal')->nullable();
//
//            $table->string('phone')->nullable();
//            $table->string('phone_code')->nullable();
//
//            $table->string('website')->nullable();
//            $table->text('notes')->nullable();
//            $table->unsignedBigInteger('merchant_id')->nullable();
//
//            $table->timestamps();
//        });
//    }
//
//    public function down(): void
//    {
//        Schema::dropIfExists('upaycustomers');
//    }
//};
