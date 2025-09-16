<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'npm',
        'name',
        'gender',
        'nomor_hp',
        'email'
    ];


    public function alternatives()
    {
        return $this->hasMany(Alternative::class);
    }
}
