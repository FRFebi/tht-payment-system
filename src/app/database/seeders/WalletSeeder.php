<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class WalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $id = DB::table('users')->insertGetId([
            'name' => "admin",
            'email' => 'admin@email.com',
            'password' => Hash::make('admin'),
            "created_at" => Carbon::now(),
        ]);

        DB::table("wallet")->insert([
            "user_id" => $id,
            "wallet_name" => "wallet_test",
            "balance" =>  12345,
            "created_at" => Carbon::now(),
        ]);
    }
}
