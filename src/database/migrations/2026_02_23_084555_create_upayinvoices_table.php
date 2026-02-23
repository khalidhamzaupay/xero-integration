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
//        Schema::create('upayinvoices', function (Blueprint $table) {
//            $table->id();
//
//            $table->string('type')->nullable();
//            $table->unsignedBigInteger('contact_id')->nullable();
//
//            $table->date('date')->nullable();
//            $table->date('due_date')->nullable();
//
//            $table->string('status')->nullable();
//            $table->string('reference')->nullable();
//            $table->text('notes')->nullable();
//
//            $table->decimal('subtotal', 15, 4)->nullable();
//            $table->decimal('total_tax', 15, 4)->nullable();
//            $table->decimal('total', 15, 4)->nullable();
//
//            $table->unsignedBigInteger('merchant_id');
//
//            $table->timestamps();
//        });
//    }
//
//    public function down(): void
//    {
//        Schema::dropIfExists('upayinvoices');
//    }
//};
