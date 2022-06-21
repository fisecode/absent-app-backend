<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class Absent extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'date',
        'status',
        'check_in',
        'check_out',
        'longitude',
        'latitude',
        'absent_spot',
        'address',
        'photo',
        'type'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'id', 'employee_id');
    }

    public function getCreatedAtAtrribute($value)
    {
        return Carbon::parse($value)->timestamp;
    }

    public function getUpdatedAtAtrribute($value)
    {
        return Carbon::parse($value)->timestamp;
    }

    public function toArray()
    {
        $toArray = parent::toArray();
        $toArray['photo'] = $this->photo;
        return $toArray;
    }

    public function getPhotoPathAttribute()
    {
        return url('') . Storage::url($this->attributes['photo']);
    }
}
