<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Employee;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        User::create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'password' => Hash::make(12345678),
            'roles' => 'Admin',
        ]);

        $user = User::create([
            'name' => 'Akhmat Fikri Septiawan',
            'email' => 'fikri@mail.com',
            'password' => Hash::make(12345678),
            'roles' => 'employee',
        ]);

        Employee::create([
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password,
            'dob' => '1995-09-24',
            'gender' => 'Male',
            'phone' => '0897777777',
            'address' => 'Rengas',
            'employee_id' => 'LMS00001',
            'doj' => '2018-12-24',
            'division' => 'Motion Grapher',
            'work_from' => 'Office',
        ]);

        for ($i = 1; $i <= 50; $i++) {
            $gender = $faker->randomElement(['Male', 'Female']);
            $workFrom = $faker->randomElement(['Office', 'Home']);
            $dtDob = $faker->dateTimeBetween('-30 years', '-20 years');
            $dateDob = $dtDob->format('Y-m-d');
            $dtDoj = $faker->dateTimeBetween('-5 years', 'now');
            $dateDoj = $dtDoj->format('Y-m-d');
            $user = User::create([
                'name' => $faker->name,
                'email' => $faker->email,
                'password' => Hash::make(12345678),
                'roles' => 'employee',
            ]);

            Employee::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'password' => $user->password,
                'dob' => $dateDob,
                'gender' => $gender,
                'phone' => $faker->phoneNumber,
                'address' => $faker->address,
                'employee_id' => 'LMS' . $faker->randomNumber(5, true),
                'doj' => $dateDoj,
                'division' => $faker->jobTitle,
                'work_from' => $workFrom,
            ]);
        }
    }
}
