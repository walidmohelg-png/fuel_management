<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // تأكد من استيراد نموذج المستخدم
use Illuminate\Support\Facades\Hash; // تأكد من استيراد الهاش

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // إنشاء المستخدم المسؤول
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com', // <--- اسم المستخدم (البريد الإلكتروني)
            'password' => Hash::make('password'), // <--- كلمة المرور
            'email_verified_at' => now(), // لتأكيد البريد الإلكتروني تلقائياً
        ]);
        
        // يمكن إضافة مستخدم ثانٍ للمحاسبة
        User::create([
            'name' => 'Data Entry',
            'email' => 'data.entry@example.com', 
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
    }
}