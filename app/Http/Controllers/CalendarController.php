<?php

namespace App\Http\Controllers;

use App\Models\CalendarEvent;
use Illuminate\View\View;

class CalendarController extends Controller
{
    public function index(): View
    {
        $events = CalendarEvent::latest()->limit(20)->get();

        return view('pages.calendar', compact('events'));
    }
}
