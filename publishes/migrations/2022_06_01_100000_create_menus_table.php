<?php

use App\Models\Menu;
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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();

            $table->string('type');
            $table->string('title');

            $table->timestamps();
        });

        Menu::create([
            'type'  => 'main',
            'title' => 'Main menu',
        ]);
        Menu::create([
            'type'  => 'footer',
            'title' => 'Footer menu',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
};
