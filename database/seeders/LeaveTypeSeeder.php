<?php

namespace Database\Seeders;

use App\Models\LeaveType;
use Illuminate\Database\Seeder;

class LeaveTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LeaveType::create([
            'name' => 'Annual Leave',
            'days' => 12
        ]);

        LeaveType::create([
            'name' => 'Sick Leave',
        ]);

        LeaveType::create([
            'name' => 'Personal Leave',
        ]);

        LeaveType::create([
            'name' => 'Maternity Leave & Breastfeeding Time',
        ]);
    }
}
