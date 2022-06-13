<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Absent;
use App\Models\AbsentSpot;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'password',
        'dob',
        'gender',
        'phone',
        'address',
        'employee_id',
        'doj',
        'division',
        'work_from',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function absent()
    {
        return $this->hasMany(Absent::class);
    }

    public function absentSpot()
    {
        return $this->belongsTo(AbsentSpot::class, 'id', 'employee_id');
    }

    public function getCreatedAtAtrribute($value)
    {
        return Carbon::parse($value)->timestamp;
    }

    public function getUpdatedAtAtrribute($value)
    {
        return Carbon::parse($value)->timestamp;
    }

    // public function toArray()
    // {
    //     $toArray = parent::toArray();
    //     $toArray['photoPath'] = $this->photoPath;
    //     return $toArray;
    // }

    // public function getPhotoPathAttribute()
    // {
    //     return url('') . Storage::url($this->attributes['photoPath']);
    // }
}
