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
//        Schema::create('upayrefunds', function (Blueprint $table) {
//            $table->id();
//
//            $table->string('credit_note_number')->nullable();
//            $table->date('date')->nullable();
//            $table->unsignedBigInteger('contact_id')->nullable();
//            $table->text('line_items')->nullable();
//            $table->string('status')->nullable();
//            $table->unsignedBigInteger('invoice_id');
//            $table->unsignedBigInteger('merchant_id');
//            $table->decimal('amount', 15, 4)->nullable();
//
//            $table->timestamps();
//        });
//    }
//
//    public function down(): void
//    {
//        Schema::dropIfExists('upayrefunds');
//    }
//};
