<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();

            $table->string('title')->nullable();
            $table->string('link')->nullable();
            $table->boolean('new_tab')->nullable();
            $table->boolean('is_group')->default(false);

            $table->foreignId('menu_id');
            $table->foreignId('parent_id')->nullable();
            $table->integer('order_column')->default(0);

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
        Schema::dropIfExists('menu_items');
    }
};
