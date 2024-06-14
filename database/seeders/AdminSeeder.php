<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::beginTransaction();
        try {
            $user = User::create([
                'email' => 'administrator@gmail.com',
                'password' => Hash::make('administrator', ['rounds' => 13]),
                'role' => 'superadmin'
            ]);
            Admin::create([
                'user_id' => $user->id,
                'name' => 'Administrator',
            ]);
            DB::commit();
        }catch (\Throwable $e) {
            DB::rollBack();
            Log::error($e->getMessage());
        }
    }
}
