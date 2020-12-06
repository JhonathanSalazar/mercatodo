<?php

use App\Constants\Permissions;
use App\Constants\PlatformRoles;
use App\Entities\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run(): void
    {
        User::truncate();
        Permission::truncate();
        Role::truncate();

        $adminRole = Role::create(['name' => PlatformRoles::ADMIN]);
        $buyerRole = Role::create(['name' => PlatformRoles::BUYER]);

        $createProductsPermission = Permission::create(['name' => Permissions::CREATE_PRODUCTS]);
        $viewProductsPermission = Permission::create(['name' => Permissions::VIEW_PRODUCTS]);
        $updateProductsPermission = Permission::create(['name' => Permissions::UPDATE_PRODUCTS]);
        $deleteProductsPermission = Permission::create(['name' => Permissions::DELETE_PRODUCTS]);

        $viewUserPermission = Permission::create(['name' => Permissions::VIEW_USERS]);
        $updateUserPermission = Permission::create(['name' => Permissions::UPDATE_USERS]);

        $exportPermission = Permission::create(['name' => Permissions::EXPORT]);
        $importPermission = Permission::create(['name' => Permissions::IMPORT]);

        $adminRole->givePermissionTo([
            $createProductsPermission,
            $viewProductsPermission,
            $updateProductsPermission,
            $deleteProductsPermission,
            $viewUserPermission,
            $updateUserPermission,
            $exportPermission,
            $importPermission
        ]);

        $admin = new User;
        $admin->name = 'Admin';
        $admin->email = 'admin@gmail.com';
        $admin->password = bcrypt('123123');
        $admin->save();
        $admin->assignRole($adminRole);

        $buyer = new User;
        $buyer->name = 'Jhon';
        $buyer->email = 'buyer@gmail.com';
        $buyer->password = bcrypt('123123');
        $buyer->save();
        $buyer->assignRole($buyerRole);

        $buyer1 = new User;
        $buyer1->name = 'Ana';
        $buyer1->email = 'buyer1@gmail.com';
        $buyer1->password = bcrypt('123123');
        $buyer1->save();
        $buyer1->assignRole($buyerRole);

        $buyer2 = new User;
        $buyer2->name = 'Ana';
        $buyer2->email = 'buyer2@gmail.com';
        $buyer2->password = bcrypt('123123');
        $buyer2->save();
        $buyer2->assignRole($buyerRole);
    }
}
