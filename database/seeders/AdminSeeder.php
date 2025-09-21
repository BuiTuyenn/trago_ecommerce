<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Tạo tài khoản admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@ecommerce.com',
            'password' => Hash::make('admin123456'),
            'role' => 'admin',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Tạo thêm một vài tài khoản admin khác (tùy chọn)
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@ecommerce.com',
            'password' => Hash::make('superadmin123'),
            'role' => 'admin',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Tạo tài khoản customer mẫu
        User::create([
            'name' => 'Khách hàng mẫu',
            'email' => 'customer@ecommerce.com',
            'password' => Hash::make('customer123'),
            'role' => 'customer',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        $this->command->info('Admin accounts created successfully!');
        $this->command->info('Admin: admin@ecommerce.com / admin123456');
        $this->command->info('Super Admin: superadmin@ecommerce.com / superadmin123');
        $this->command->info('Customer: customer@ecommerce.com / customer123');
    }
}
