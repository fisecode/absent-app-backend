<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsentSpot extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'name_spot',
        'latitude',
        'longitude',
        'address',
    ];

    public function employee()
    {
        return $this->hashOne(Employee::class, 'id', 'employee_id');
    }
}
