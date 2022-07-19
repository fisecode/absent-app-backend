<?php

namespace App\Exports;

use App\Models\Leave;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportLeave implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $leaves = Leave::with('employee', 'leaveType')->get();
        return $leaves;
    }

    public function map($leaves): array
    {
        return [
            [
                $leaves->employee->name,
                $leaves->leaveType->name,
                $leaves->applied_on,
                $leaves->start_date,
                $leaves->end_date,
                $leaves->total_leave_days,
                $leaves->status
            ],

        ];
    }

    public function headings(): array
    {
        return [
            'Name',
            'Leave Type',
            'Applied On',
            'Start Date',
            'End Date',
            'Total Leave Days',
            'Status'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }
}
