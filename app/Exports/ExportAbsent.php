<?php

namespace App\Exports;

use App\Models\Absent;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportAbsent implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $absents = Absent::with('employee')->get();
        return $absents;
    }

    public function map($absents): array
    {
        return [
            [
                $absents->employee->name,
                $absents->date,
                $absents->status,
                $absents->check_in,
                $absents->check_out,
                $absents->absent_spot,
                $absents->latitude,
                $absents->longitude,
                $absents->address,
            ],

        ];
    }

    public function headings(): array
    {
        return [
            'Name',
            'Date',
            'Status',
            'Check In',
            'Check Out',
            'Absent Spot',
            'latitude',
            'Longitude',
            'address',
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
