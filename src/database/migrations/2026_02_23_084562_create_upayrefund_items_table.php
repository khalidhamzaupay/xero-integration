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
//        Schema::create('upayrefund_items', function (Blueprint $table) {
//            $table->id();
//
//            $table->unsignedBigInteger('refund_id');
//            $table->string('description')->nullable();
//            $table->decimal('quantity', 15, 4)->nullable();
//            $table->decimal('unit_amount', 15, 4)->nullable();
//            $table->string('item_code')->nullable();
//            $table->string('tax_type')->nullable();
//
//            $table->timestamps();
//        });
//    }
//
//    public function down(): void
//    {
//        Schema::dropIfExists('upayrefund_items');
//    }
//};
