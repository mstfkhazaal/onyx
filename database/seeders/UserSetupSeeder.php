<?php

namespace Database\Seeders;

use App\Models\Entity;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSetupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::upsert([[
            'id' => 1,
            'name' => 'Moustafa Khazaal',
            'email' => 'admin@gmail.com',
            'user_status_id' => 2,
            'password' => Hash::make('123456789'),
            'remember_token' => Str::random(10),
            'profile_photo_path' => null,
            'first_name' => json_encode(['en' => 'Moustafa', 'ar' => 'مصطفى']),
            'last_name' => json_encode(['en' =>  'Khazaal', 'ar' => 'خزعل']),
            'nationality_id' => 2,
            'email_verified_at'=>Carbon::now(),
            'gender_id' => 2,
            'date_of_birth' => '1997-7-28',
            'address' => 'Baalbeck',
            'phone' => '76977828',
            'bio' => null,
        ]],['id','name','email','email_verified_at','password',
            'user_status_id','profile_photo_path','first_name','last_name',
            'nationality_id','gender_id','date_of_birth','address','phone',
            'bio','created_at','updated_at']);

      //  DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }
}
