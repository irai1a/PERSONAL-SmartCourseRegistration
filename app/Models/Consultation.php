<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;

    protected $fillable = ['advisor_id', 'student_id', 'scheduled_at', 'status'];

    public function advisor()
    {
        return $this->belongsTo(User::class, 'advisor_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
