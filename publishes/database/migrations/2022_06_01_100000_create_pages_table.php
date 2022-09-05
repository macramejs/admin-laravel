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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')-> nullable();
            $table->string('preview_key')->nullable();
            $table->string('template')->nullable();
            $table->text('content');
            $table->text('attributes');
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->boolean('is_live')->default(false);
            $table->boolean('is_root')->default(false);
            $table->integer('order_column')->default(0);
            $table->foreignId('parent_id')->nullable();
            $table->foreignId('creator_id')->nullable();
            $table->dateTime('publish_at')->nullable();
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
        Schema::dropIfExists('pages');
    }
};
