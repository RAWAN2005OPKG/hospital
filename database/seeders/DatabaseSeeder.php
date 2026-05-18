<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Department;
use App\Models\Specialization;
use App\Models\Schedule;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
// الأقسام
        $departments = [
            ['name' => 'طب عام', 'description' => 'قسم الطب العام', 'manager_name' => 'د. أحمد', 'phone' => '0112345678'],
            ['name' => 'أسنان', 'description' => 'قسم طب الأسنان', 'manager_name' => 'د. محمد', 'phone' => '0112345679'],
            ['name' => 'جراحة', 'description' => 'قسم الجراحة', 'manager_name' => 'د. خالد', 'phone' => '0112345680'],
            ['name' => 'نساء وتوليد', 'description' => 'قسم النساء والتوليد', 'manager_name' => 'د. سارة', 'phone' => '0112345681'],
            ['name' => 'أطفال', 'description' => 'قسم طب الأطفال', 'manager_name' => 'د. علي', 'phone' => '0112345682'],
        ];

        foreach ($departments as $dept) {
            Department::create($dept);
        }

        // التخصصات
        $specializations = [
            ['name' => 'طبيب عام', 'description' => 'طبيب عام'],
            ['name' => 'طبيب أسنان', 'description' => 'طبيب أسنان'],
            ['name' => 'جراح', 'description' => 'جراح عام'],
            ['name' => 'طبيب نساء', 'description' => 'طبيب نساء وتوليد'],
            ['name' => 'طبيب أطفال', 'description' => 'طبيب أطفال'],
        ];

        foreach ($specializations as $spec) {
            Specialization::create($spec);
        }

        // مريض
        $patient = User::create([
            'name' => 'محمد المريض',
            'email' => 'patient@example.com',
            'password' => bcrypt('password'),
            'role' => 'patient',
            'phone' => '0501234567',
            'address' => 'الرياض',
        ]);

        // طبيب
        $doctorUser = User::create([
            'name' => 'د. أحمد الطبيب',
            'email' => 'doctor@example.com',
            'password' => bcrypt('password'),
            'role' => 'doctor',
            'phone' => '0509876543',
            'address' => 'الرياض',
        ]);

        $doctor = Doctor::create([
            'user_id' => $doctorUser->id,
            'department_id' => 1,
            'specialization_id' => 1,
            'license_number' => 'LIC123456',
            'experience_years' => 10,
            'bio' => 'طبيب عام متخصص مع خبرة 10 سنوات',
            'consultation_fee' => 100,
        ]);

        // جدول الطبيب
        for ($day = 0; $day < 6; $day++) {
            Schedule::create([
                'doctor_id' => $doctor->id,
                'day_of_week' => $day,
                'start_time' => '09:00',
                'end_time' => '17:00',
                'break_start' => '12:00',
                'break_end' => '13:00',
            ]);
        }

        // مدير
        User::create([
            'name' => 'المدير',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'phone' => '0505555555',
            'address' => 'الرياض',
        ]);
    }
}