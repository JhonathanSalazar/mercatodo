<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->string('order_reference')->unique();
            $table->unsignedBigInteger('user_id');
            $table->string('status')->default('PENDING');
            $table->string('reason')->nullable();
            $table->text('message')->nullable();
            $table->bigInteger('grand_total');
            $table->integer('item_count');
            $table->timestamp('paid_at')->nullable();
            $table->string('payer_name');
            $table->string('payer_email');
            $table->enum('document_type',['CC', 'DI']);
            $table->string('document_number');
            $table->string('payer_phone');
            $table->string('payer_address');
            $table->string('payer_city');
            $table->string('payer_state');
            $table->string('payer_postal');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('orders');
    }
}
