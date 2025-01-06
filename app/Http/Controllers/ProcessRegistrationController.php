<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SectionInfo;

class ProcessRegistrationController extends Controller
{

    public function showSections($course_id)
    {
        // Fetch sections for the selected course
        $sections = SectionInfo::where('course_id', $course_id)->get();
        $userEnrolledSection = SectionInfo::where('course_id', $course_id)
            ->where('user_id', Auth::id())
            ->first();

        return view('student.processRegistration', compact('sections', 'course_id', 'userEnrolledSection'));
    }
    /**
     * Enroll or Unenroll user into/from a section.
     */
    public function enroll(Request $request)
    {

        // Validate the incoming request
        $validated = $request->validate([
            'section_id' => 'required|exists:section_info,id',
            'course_id' => 'required|exists:courses,id',
        ]);

        $user = Auth::user();

        // Find the section
        $section = SectionInfo::findOrFail($validated['section_id']);

        // Check if the user is already enrolled in the section
        if ($section->user_id === $user->id) {
            // Unenroll the user
            $section->user_id = null;
            $section->capacity += 1; // Increase capacity on unenroll
            $section->save();

            return redirect()->route('processRegistration.show', ['course_id' => $validated['course_id']])
                ->with('success', 'You have successfully unenrolled from the section.');
        }

        // Check if user is already enrolled in any section of the same course
        $alreadyEnrolled = SectionInfo::where('course_id', $validated['course_id'])
            ->where('user_id', $user->id)
            ->exists();

        if ($alreadyEnrolled) {
            return redirect()->route('processRegistration.show', ['course_id' => $validated['course_id']])
                ->with('error', 'You are already enrolled in a section for this course.');
        }

        // Check if there are available seats
        if ($section->capacity <= 0) {
            return redirect()->route('processRegistration.show', ['course_id' => $validated['course_id']])
                ->with('error', 'This section is already full.');
        }

        // Enroll the user and decrease capacity
        $section->user_id = $user->id;
        $section->capacity -= 1; // Decrease capacity
        $section->save();

        return redirect()->route('processRegistration.show', ['course_id' => $validated['course_id']])
            ->with('success', 'You have successfully enrolled in the section.');


    }
}
