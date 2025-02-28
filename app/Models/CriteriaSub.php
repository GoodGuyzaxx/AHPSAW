<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CriteriaSub extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_sub',
        'value',
        'criteria_id'
    ];

    public function criteria()
    {
        return $this->belongsTo(Criteria::class);
    }
}
