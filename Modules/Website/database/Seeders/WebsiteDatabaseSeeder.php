<?php

namespace Modules\Website\database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Website\database\Seeders\CategorySeeder;
use Modules\Website\database\Seeders\ProductSeeder;


class WebsiteDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Gọi theo thứ tự: Danh mục trước -> Sản phẩm sau
        // php artisan db:seed --class="Modules\Website\database\Seeders\WebsiteDatabaseSeeder"
        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
        ]);
    }
}
