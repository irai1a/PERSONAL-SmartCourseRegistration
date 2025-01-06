<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class DegreeProgressController extends Controller
{
    // Show Degree Progress Page
    public function showProgress()
    {
        $student = Auth::user();
        $completedCourses = $student->completedCourses()->get();
        $degreePlan = $student->degreePlan;

        $totalCourses = $degreePlan->totalCourses();
        $completedCount = $completedCourses->count();

        // Calculate percentage completion
        $completionRate = ($completedCount / $totalCourses) * 100;

        // Fetch suggestions for electives
        $suggestedElectives = $this->getSuggestedElectives($student);

        return view('student.degree_progress', compact(
            'completedCourses',
            'totalCourses',
            'completionRate',
            'suggestedElectives'
        ));
    }

    // Function to get suggested electives
    private function getSuggestedElectives($student)
    {
        // Example logic to get suggested electives based on degree requirements
        $completedCourseIds = $student->completedCourses()->pluck('id');
        return Course::where('type', 'elective')
                     ->whereNotIn('id', $completedCourseIds)
                     ->get();
    }
}

