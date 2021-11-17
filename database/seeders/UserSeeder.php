<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::updateOrCreate(
            [
                'email' => 'admin@mail.com'
            ],
            [
                'first_name' => 'Admin',
                'last_name' => 'Admin',
                'username' => 'admin_admin',
                'email' => 'admin@mail.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('admin@mail.com'),
                'api_token'  => Str::random( 80 )
            ]
        );

        $user->roles()->sync([Role::where('name', 'admin')->first()->id]);
    }
}
