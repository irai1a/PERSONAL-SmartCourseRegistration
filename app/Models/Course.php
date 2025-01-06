<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_code',
        'subject_name',
        'credit_hours',
        'no_section',
        'semester',
    ];

    public function sections()
    {
        return $this->hasMany(SectionInfo::class, 'course_id');
    }

}
