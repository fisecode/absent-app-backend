<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportEmployee implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Employee::select('name', 'email', 'dob', 'gender', 'phone', 'address', 'employee_id', 'doj', 'division', 'work_from')->get();
    }
}
