<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SectionInfo;

class StudentCourseRegisteredController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Get all sections the user is enrolled in
        $registeredSections = SectionInfo::where('user_id', $user->id)->get();

        return view('student.studentCourseRegistered', compact('registeredSections'));

    }
}
