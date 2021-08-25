<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * @return void
     */
    public function run()
    {
        $sql = "INSERT INTO `modules` (`id`, `menu_id`, `type`, `module_name`, `divider_name`, `icon_class`, `url`, `order`, `parent_id`, `target`, `created_at`, `updated_at`) VALUES
        (1, 1, '2', 'Dashboard', NULL, 'fas fa-tachometer-alt', '/', 1, NULL, '_self', NULL, '2021-08-25 03:15:18'),
        (2, 1, '1', NULL, 'Menus', NULL, NULL, 2, NULL, '_self', NULL, '2021-08-25 03:15:18'),
        (3, 1, '1', NULL, 'Access Control', NULL, NULL, 4, NULL, '_self', NULL, '2021-08-22 23:29:47'),
        (4, 1, '2', 'User', NULL, 'fas fa-users', 'user', 5, NULL, '_self', NULL, '2021-08-22 23:29:47'),
        (5, 1, '2', 'Role', NULL, 'fas fa-user-tag', 'role', 6, NULL, '_self', NULL, '2021-08-22 23:29:47'),
        (6, 1, '1', NULL, 'System', NULL, NULL, 7, NULL, '_self', NULL, '2021-08-22 23:29:47'),
        (7, 1, '2', 'Menu', NULL, 'fas fa-th-list', 'menu', 8, NULL, '_self', NULL, '2021-08-22 23:29:47'),
        (8, 1, '2', 'Setting', NULL, 'fas fa-cogs', 'setting', 9, NULL, '_self', NULL, '2021-08-22 23:29:47'),
        (9, 1, '2', 'Permission', NULL, 'fas fa-tasks', 'menu/module/permission', 10, NULL, '_self', NULL, '2021-08-22 23:29:47'),
        (10, 1, '2', 'Product', NULL, 'fab fa-product-hunt', NULL, 3, NULL, '_self', '2021-08-22 23:26:33', '2021-08-22 23:27:06'),
        (11, 1, '2', 'Category', NULL, 'fas fa-list', 'category', 1, 10, '_self', '2021-08-22 23:29:32', '2021-08-22 23:29:47')";

        DB::select($sql);
    }
}
