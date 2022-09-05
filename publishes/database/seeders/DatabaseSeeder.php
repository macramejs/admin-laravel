<?php

namespace Database\Seeders;

use App\Models\MediaCollection;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory([
            'name'     => 'admin',
            'email'    => 'admin@admin.com',
            'password' => bcrypt('secret'),
            'is_admin' => true,
        ])->create();

        $this->call([
            //...
        ]);

    }
}
