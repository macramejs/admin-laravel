<?php

use App\Models\Menu;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
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
            $table->string('title')->nullable();

            $table->timestamps();
        });

        Menu::create([
            'type' => 'main',
            'title' => [
                'de' => 'Hauptmenü',
                'en' => 'Main menu',
            ],
        ]);
        Menu::create([
            'type' => 'footer',
            'title' => [
                'de' => 'Fußzeilen Menü',
                'en' => 'Footer menu',
            ],
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
