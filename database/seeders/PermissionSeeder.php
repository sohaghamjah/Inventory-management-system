<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sql = "INSERT INTO `permissions` (`id`, `module_id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
        (1, 9, 'Permission Access', 'permission-access', '2021-08-22 23:34:45', NULL),
        (2, 9, 'Permission Add', 'permission-add', '2021-08-22 23:34:45', NULL),
        (3, 9, 'Permission Edit', 'permission-edit', '2021-08-22 23:34:45', NULL),
        (4, 9, 'Permission Delete', 'permission-delete', '2021-08-22 23:34:45', NULL),
        (5, 9, 'Permission Bulk Delete', 'permission-bulk-delete', '2021-08-22 23:34:45', NULL),
        (6, 9, 'Permission Report', 'permission-report', '2021-08-22 23:34:45', NULL),
        (7, 8, 'Setting Access', 'setting-access', '2021-08-22 23:35:05', NULL),
        (8, 7, 'Menu Access', 'menu-access', '2021-08-22 23:38:03', NULL),
        (9, 7, 'Menu Add', 'menu-add', '2021-08-22 23:38:03', NULL),
        (10, 7, 'Menu Edit', 'menu-edit', '2021-08-22 23:38:03', NULL),
        (11, 7, 'Menu Delete', 'menu-delete', '2021-08-22 23:38:03', NULL),
        (12, 7, 'Menu Bulk Delete', 'menu-bulk-delete', '2021-08-22 23:38:03', NULL),
        (13, 7, 'Menu Report', 'menu-report', '2021-08-22 23:38:03', NULL),
        (14, 7, 'Menu Builder', 'menu-builder', '2021-08-22 23:38:03', NULL),
        (18, 5, 'Role Access', 'role-access', '2021-08-22 23:39:10', NULL),
        (19, 5, 'Role Add', 'role-add', '2021-08-22 23:39:10', NULL),
        (20, 5, 'Role Edit', 'role-edit', '2021-08-22 23:39:10', NULL),
        (21, 5, 'Role Delete', 'role-delete', '2021-08-22 23:39:10', NULL),
        (22, 5, 'Role Bulk Delete', 'role-bulk-delete', '2021-08-22 23:39:10', NULL),
        (23, 5, 'Role Report', 'role-report', '2021-08-22 23:39:10', NULL),
        (24, 4, 'User Access', 'user-access', '2021-08-22 23:41:41', NULL),
        (25, 4, 'User Add', 'user-add', '2021-08-22 23:41:41', NULL),
        (26, 4, 'User Edit', 'user-edit', '2021-08-22 23:41:41', NULL),
        (27, 4, 'User Delete', 'user-delete', '2021-08-22 23:41:41', NULL),
        (28, 4, 'User Bulk Delete', 'user-bulk-delete', '2021-08-22 23:41:41', NULL),
        (29, 4, 'User Report', 'user-report', '2021-08-22 23:41:41', NULL),
        (30, 11, 'Category Access', 'category-access', '2021-08-22 23:47:57', NULL),
        (31, 11, 'Category Add', 'category-add', '2021-08-22 23:47:57', NULL),
        (32, 11, 'Category Edit', 'category-edit', '2021-08-22 23:47:57', NULL),
        (33, 11, 'Category Delete', 'category-delete', '2021-08-22 23:47:57', NULL),
        (34, 11, 'Category Bulk Delete', 'category-bulk-delete', '2021-08-22 23:47:57', NULL),
        (35, 11, 'Category Report', 'category-report', '2021-08-22 23:47:57', NULL),
        (36, 9, 'Permission Show', 'permission-show', '2021-08-23 07:00:31', '2021-08-23 10:10:23'),
        (37, 7, 'menu-module-add', 'menu-module-add', '2021-08-23 07:56:57', NULL),
        (38, 7, 'menu-module-edit', 'menu-module-edit', '2021-08-23 07:56:57', NULL),
        (39, 7, 'menu-module-delete', 'menu-module-delete', '2021-08-23 07:56:57', NULL),
        (40, 4, 'User Show', 'user-show', '2021-08-23 09:13:26', NULL),
        (42, 5, 'Role Show', 'role-show', '2021-08-23 10:43:12', NULL)";

        DB::select($sql);
    }
}
