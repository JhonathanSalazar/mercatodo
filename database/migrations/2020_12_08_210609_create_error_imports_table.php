<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErrorImportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('error_imports', function (Blueprint $table) {
            $table->id();
            $table->string('import', 50)->nullable();
            $table->unsignedInteger('row')->nullable();
            $table->string('attribute', 100)->nullable();
            $table->string('values', 300)->nullable();
            $table->string('errors', 300)->nullable();
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
        Schema::dropIfExists('error_imports');
    }
}
