<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseRegistrationController extends Controller
{
    /**
     * Show the list of subjects available for registration with semester filtering.
     *
     * @param Request $request
     */
    public function showSubjectList(Request $request)
    {
        // Fetch unique semesters for the dropdown
        $semesters = Course::select('semester')->distinct()->pluck('semester');

        // Filter subjects based on selected semester (if any)
        $selectedSemester = $request->query('semester');

        if ($selectedSemester) {
            $subjects = Course::where('semester', $selectedSemester)->get();
        } else {
            $subjects = Course::all();
        }

        // Pass data to the view
        return view('student.courseRegistration', compact('subjects', 'semesters', 'selectedSemester'));
    }

    /**
     * Process the subject registration.
     *
     * @param Request $request
     * @param int $subject_id
     */
    public function processRegistration($subject_id)
    {
        // Fetch the subject
        $subject = Course::findOrFail($subject_id);

        // Implement logic to register the subject (placeholder example)
        // Example: Save subject to the user's registered courses
        $user = auth()->user();
        $user->registeredSubjects()->attach($subject_id);

        // Redirect to the registered courses page
        return redirect()->route('processRegistration.show')
            ->with('success', "Successfully registered for {$subject->name}.");
    }

    /**
     * Fetch Courses by Semester (API endpoint).
     *
     * @param string $semester
     */
    public function getCoursesBySemester($semester)
    {
        $courses = Course::where('semester', $semester)->get();
        return response()->json($courses);
    }
}
