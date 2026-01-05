<?php

namespace Modules\Website\database\Seeders;

use Illuminate\Database\Seeder;

class WebsiteDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
        ]);
    }
}
