<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DegreePlan extends Model
{
    // Function to get the total number of courses (mandatory + elective)
    public function totalCourses(): int
    {
        return $this->mandatoryCourses()->count() + $this->electiveCourses()->count();
    }

    // Function to get pending mandatory courses based on completed courses
    public function getPendingMandatoryCourses($completedCourses)
    {
        return $this->mandatoryCourses()->whereNotIn('id', $completedCourses->pluck('id'));
    }
}
