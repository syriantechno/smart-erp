<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RecruitmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get statistics for the royal theme header
        $openPositions = 45; // Open positions count
        $totalApplications = 156; // Total applications
        $interviewsToday = 5; // Interviews scheduled for today
        $hiredThisMonth = 23; // Hired this month

        return view('hr.recruitment.index', compact('openPositions', 'totalApplications', 'interviewsToday', 'hiredThisMonth'));
    }
}
