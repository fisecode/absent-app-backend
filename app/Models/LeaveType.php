<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Leave;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LeaveType extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'days'
    ];

    public function leave()
    {
        return $this->hasMany(Leave::class);
    }

    public function getCreatedAtAtrribute($value)
    {
        return Carbon::parse($value)->timestamp;
    }

    public function getUpdatedAtAtrribute($value)
    {
        return Carbon::parse($value)->timestamp;
    }
}
