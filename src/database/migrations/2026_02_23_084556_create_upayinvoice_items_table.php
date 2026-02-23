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
//        Schema::create('upayinvoice_items', function (Blueprint $table) {
//            $table->id();
//
//            $table->unsignedBigInteger('invoice_id');
//
//            $table->string('item_code')->nullable();
//            $table->text('description')->nullable();
//
//            $table->decimal('quantity', 15, 4)->nullable();
//            $table->decimal('unit_amount', 15, 4)->nullable();
//
//            $table->string('account_code')->nullable();
//            $table->string('tax_type')->nullable();
//            $table->decimal('tax_amount', 15, 4)->nullable();
//            $table->decimal('discount_rate', 8, 4)->nullable();
//
//            $table->timestamps();
//        });
//    }
//
//    public function down(): void
//    {
//        Schema::dropIfExists('upayinvoice_items');
//    }
//};
