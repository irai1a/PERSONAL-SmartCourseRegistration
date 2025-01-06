<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionInfo extends Model
{
    use HasFactory;
    protected $primaryKey = 'id'; // If renamed
    public $timestamps = true;


    protected $fillable = ['section', 'capacity', 'lect_assigned', 'user_id', 'course_id'];

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relationship with Course
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    // Explicitly specify the table name
    protected $table = 'section_info';


}
