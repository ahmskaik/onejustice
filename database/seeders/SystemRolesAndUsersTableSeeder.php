<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SystemRolesAndUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('roles')->insert(['name' => 'admin', 'status' => 2]);
        $status = \App\Models\SystemLookupModel::getIdByKey('SYSTEM_USER_STATUS_ACTIVE');

        \App\Models\SystemUserModel::create([
            'full_name' => 'Ahmed Skaik',
            'user_name' => 'admin',
            'email' => 'ahmskaik@gmail.com',
            'password' => bcrypt('123'),
            'status' => $status,
        ])->actions()->attach(
            \App\Models\ActionModel::all()->pluck('id')->toArray()
        );

        \DB::table('system_user_roles')->insert(['user_id' => 1, 'role_id' => 1, 'is_customized' => false]);
    }
}
