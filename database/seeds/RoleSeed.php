<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'dj',
        ]);
        Role::create([
            'name' => 'party',
        ]);
        Role::create([
            'name' => 'regular',
        ]);
        Role::create([
            'name' => 'band',
        ]);

        \App\Models\User::create([
            'name' => 'Quantox Band',
            'email' => 'qband@local.loc',
            'password' => bcrypt('testiranje'),
        ]);

        $band = \Illuminate\Support\Facades\DB::table('users')->where('email', 'qband@local.loc')->first();

        $roleBand = \Illuminate\Support\Facades\DB::table('roles')->where('name', 'band')->first();

        \Illuminate\Support\Facades\DB::table('users_roles')->insert([
            'role_id' => $roleBand->id,
            'user_id' => $band->id,
        ]);
    }
}
