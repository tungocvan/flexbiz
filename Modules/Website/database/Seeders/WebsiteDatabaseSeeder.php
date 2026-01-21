<?php

namespace Modules\Website\database\Seeders;

use Illuminate\Database\Seeder;
// Import các Class Seeder
use Modules\Website\database\Seeders\UserSeeder;
use Modules\Website\database\Seeders\CategorySeeder;
use Modules\Website\database\Seeders\ProductSeeder;
use Modules\Website\database\Seeders\OrderSeeder;
use Modules\Website\database\Seeders\MenuCategorySeeder;
use Modules\Website\database\Seeders\RolesAndPermissionsSeeder;
use Modules\Website\database\Seeders\UserAdminSeeder;


class WebsiteDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Chạy lệnh: php artisan db:seed --class="Modules\Website\database\Seeders\WebsiteDatabaseSeeder"

        $this->call([
            //
            RolesAndPermissionsSeeder::class,
            // 1. Tạo người dùng trước
            UserAdminSeeder::class,
            UserSeeder::class,

            // 2. Tạo danh mục
            CategorySeeder::class,

            // 3. Tạo sản phẩm (gắn với danh mục)
            ProductSeeder::class,

            // 4. Tạo đơn hàng (gắn với User và Sản phẩm)
            OrderSeeder::class,
            // 5. Tạo menu sidebar
            MenuCategorySeeder::class,
        ]);
    }
}
