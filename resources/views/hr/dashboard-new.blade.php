<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR Dashboard – Crextio Replica</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-start: #e6e3dc;
            --bg-mid: #efe4cf;
            --bg-end: #f8dc8b;
            --card-shadow: 0 20px 45px rgba(15, 23, 42, 0.10);
        }
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, var(--bg-start) 0%, var(--bg-mid) 45%, var(--bg-end) 100%);
            min-height: 100vh;
            color: #111827;
        }
        .nav-pill button {
            transition: all 0.2s ease;
        }
        .metric-number {
            font-size: 2.8rem;
            font-weight: 600;
            letter-spacing: -0.04em;
        }
        .metric-label {
            font-size: 0.62rem;
            letter-spacing: 0.24em;
            text-transform: uppercase;
            color: #7c7c7c;
        }
        .metric-icon {
            width: 42px;
            height: 42px;
            border-radius: 999px;
            background: rgba(0,0,0,0.08);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .lite-card {
            border-radius: 28px;
            background: rgba(255,255,255,0.92);
            box-shadow: var(--card-shadow);
        }
        .funnel-pill {
            border-radius: 999px;
            height: 36px;
            padding: 0 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.78rem;
            font-weight: 600;
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.35);
        }
        .project-pill {
            border-radius: 999px;
            height: 36px;
            padding: 0 18px;
            background: #ded8cf;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            font-size: 0.78rem;
            font-weight: 600;
            color: #5a5a5a;
        }
        .project-pill span {
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .project-bar {
            width: 180px;
            height: 12px;
            border-radius: 999px;
            background: #cbbfb1;
            position: relative;
            overflow: hidden;
        }
        .project-bar::after {
            content: '';
            position: absolute;
            inset: 0;
            background: repeating-linear-gradient(135deg, rgba(255,255,255,0.7) 0, rgba(255,255,255,0.7) 8px, transparent 8px, transparent 16px);
        }
        .project-bar-fill {
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, rgba(255,255,255,0.25), rgba(255,255,255,0.8));
            width: 60%;
        }
        .profile-card {
            border-radius: 36px;
            background: linear-gradient(135deg, #fdfdfb, #f3ebe0);
            box-shadow: var(--card-shadow);
        }
        .dark-task-card {
            border-radius: 40px;
            background: linear-gradient(180deg, #121826 0%, #080b15 100%);
            box-shadow: 0 30px 50px rgba(2, 6, 23, 0.55);
        }
        .calendar-grid span {
            border-radius: 18px;
            padding: 0.3rem 0;
        }
    </style>
</head>
<body>
    <div class="max-w-6xl mx-auto px-6 py-6 space-y-6">
        <!-- Top navigation -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-[18px] bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white text-lg font-semibold flex items-center justify-center">C</div>
                <div>
                    <p class="text-sm text-gray-500 tracking-[0.4em] uppercase">Crextio</p>
                    <p class="text-xl font-semibold text-gray-900">HR Platform</p>
                </div>
            </div>
            <div class="hidden md:flex items-center gap-1 nav-pill">
                <button class="px-4 py-1.5 rounded-full text-xs font-semibold bg-gray-900 text-white shadow">Dashboard</button>
                <button class="px-4 py-1.5 rounded-full text-xs text-gray-600">People</button>
                <button class="px-4 py-1.5 rounded-full text-xs text-gray-600">Hiring</button>
                <button class="px-4 py-1.5 rounded-full text-xs text-gray-600">Devices</button>
                <button class="px-4 py-1.5 rounded-full text-xs text-gray-600">Apps</button>
                <button class="px-4 py-1.5 rounded-full text-xs text-gray-600">Salary</button>
                <button class="px-4 py-1.5 rounded-full text-xs text-gray-600">Calendar</button>
                <button class="px-4 py-1.5 rounded-full text-xs text-gray-600">Reviews</button>
                <button class="px-4 py-1.5 rounded-full text-xs text-gray-600 flex items-center gap-1">
                    Setting
                    <span class="w-4 h-4 rounded-full border border-gray-400 flex items-center justify-center text-[10px]">⚙</span>
                </button>
            </div>
            <div class="flex items-center gap-3 text-gray-600">
                <button class="w-9 h-9 rounded-full border border-gray-300 flex items-center justify-center">?</button>
                <button class="w-9 h-9 rounded-full border border-gray-300 flex items-center justify-center">🔔</button>
                <button class="w-10 h-10 rounded-full bg-gray-900 text-white text-xs flex items-center justify-center">OP</button>
            </div>
        </div>

        <!-- Welcome & metrics -->
        <div class="flex flex-wrap items-center justify-between gap-6">
            <div>
                <p class="text-xs uppercase tracking-[0.35em] text-gray-500">Dashboard</p>
                <h1 class="text-[2.75rem] font-semibold text-gray-900">Welcome in, Nixtio</h1>
            </div>
            <div class="flex flex-wrap items-center gap-6">
                <div class="flex items-center gap-3 flex-wrap">
                    <div class="funnel-pill bg-gray-900 text-white">15%</div>
                    <div class="funnel-pill bg-amber-300 text-gray-900">15%</div>
                    <div class="project-pill">
                        <span>Project time</span>
                        <div class="project-bar">
                            <div class="project-bar-fill"></div>
                        </div>
                        <span>60%</span>
                    </div>
                    <div class="funnel-pill bg-gray-200 text-gray-700">10%</div>
                </div>
                <div class="flex flex-wrap items-end gap-6">
                    <div class="flex items-end gap-3">
                        <div class="metric-icon">
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M17 20v-2a4 4 0 00-4-4H7a4 4 0 00-4 4v2m6-10a4 4 0 100-8 4 4 0 000 8zm9-4h3m-1.5-1.5v3" />
                            </svg>
                        </div>
                        <div>
                            <p class="metric-number">78</p>
                            <p class="metric-label">Employee</p>
                        </div>
                    </div>
                    <div class="flex items-end gap-3">
                        <div class="metric-icon">
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M16 14v-2a4 4 0 00-3-3.87M8 14v-2a4 4 0 013-3.87M18 5a2 2 0 11-4 0 2 2 0 014 0zM8 5a2 2 0 11-4 0 2 2 0 014 0zM8 5v1a7 7 0 006 6.93" />
                            </svg>
                        </div>
                        <div>
                            <p class="metric-number">56</p>
                            <p class="metric-label">Hirings</p>
                        </div>
                    </div>
                    <div class="flex items-end gap-3">
                        <div class="metric-icon">
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M9 17l3 3L22 7M2 12h7l3-8 4 12h6" />
                            </svg>
                        </div>
                        <div>
                            <p class="metric-number">203</p>
                            <p class="metric-label">Projects</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main grid -->
        <div class="grid grid-cols-12 gap-6">
            <!-- Left Column -->
            <div class="col-span-5 space-y-5">
                <div class="profile-card p-6 flex gap-5">
                    <div class="rounded-[30px] overflow-hidden w-2/3 aspect-[4/3] bg-center bg-cover" style="background-image:url('https://images.pexels.com/photos/1181686/pexels-photo-1181686.jpeg?auto=compress&cs=tinysrgb&w=800');"></div>
                    <div class="flex-1 flex flex-col justify-between">
                        <div>
                            <p class="text-lg font-semibold text-gray-900">Lora Piterson</p>
                            <p class="text-sm text-gray-500">UX/UI Designer</p>
                        </div>
                        <div class="self-start rounded-full bg-white/80 px-4 py-1 text-gray-800 text-sm font-semibold shadow">$1,200</div>
                    </div>
                </div>
                <div class="lite-card p-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Pension contributions</p>
                            <p class="font-semibold text-gray-800">Updated 2024</p>
                        </div>
                        <span class="text-xs text-gray-400">View</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Devices</p>
                            <p class="font-semibold text-gray-800">MacBook Air · M1</p>
                        </div>
                        <span class="text-xs text-gray-400">Version M1</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Compensation Summary</p>
                            <p class="font-semibold text-gray-800">Annual review</p>
                        </div>
                        <span class="text-xs text-gray-400">PDF</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Employee Benefits</p>
                            <p class="font-semibold text-gray-800">Health, Dental, PTO</p>
                        </div>
                        <span class="text-xs text-gray-400">Details</span>
                    </div>
                </div>
            </div>

            <!-- Center Column -->
            <div class="col-span-4 space-y-5">
                <div class="lite-card p-6">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Progress</p>
                            <p class="text-3xl font-semibold text-gray-900">6.1 h</p>
                            <p class="text-xs text-gray-400">Work time this week</p>
                        </div>
                        <div class="text-right text-xs text-gray-500">
                            <p class="px-3 py-1 rounded-full bg-gray-900 text-white text-[10px]">5h 25m</p>
                            <button class="mt-3 w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center">↗</button>
                        </div>
                    </div>
                    <div class="mt-6 flex items-end justify-between h-28">
                        <div class="flex flex-col items-center gap-1 text-[11px] text-gray-400">
                            <div class="w-2 rounded-full bg-gray-300 h-10"></div>
                            <span>M</span>
                        </div>
                        <div class="flex flex-col items-center gap-1 text-[11px] text-gray-400">
                            <div class="w-2 rounded-full bg-gray-400 h-16"></div>
                            <span>T</span>
                        </div>
                        <div class="flex flex-col items-center gap-1 text-[11px] text-gray-400">
                            <div class="w-2 rounded-full bg-gray-500 h-20"></div>
                            <span>W</span>
                        </div>
                        <div class="flex flex-col items-center gap-1 text-[11px] text-gray-900">
                            <div class="w-3 rounded-[999px] bg-amber-300 h-24"></div>
                            <span>F</span>
                        </div>
                        <div class="flex flex-col items-center gap-1 text-[11px] text-gray-400">
                            <div class="w-2 rounded-full bg-gray-400 h-16"></div>
                            <span>S</span>
                        </div>
                        <div class="flex flex-col items-center gap-1 text-[11px] text-gray-400">
                            <div class="w-2 rounded-full bg-gray-300 h-8"></div>
                            <span>S</span>
                        </div>
                    </div>
                </div>

                <div class="lite-card p-6">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Time tracker</p>
                            <p class="text-xs text-gray-400">Work time</p>
                        </div>
                        <button class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center">↗</button>
                    </div>
                    <div class="flex justify-center py-6">
                        <div class="relative w-36 h-36">
                            <svg class="absolute inset-0" viewBox="0 0 120 120">
                                <circle cx="60" cy="60" r="50" stroke="#f1f1f1" stroke-width="10" fill="none" />
                                <circle cx="60" cy="60" r="50" stroke="#f9c045" stroke-width="10" fill="none" stroke-linecap="round" stroke-dasharray="220" stroke-dashoffset="70" />
                            </svg>
                            <div class="absolute inset-0 flex flex-col items-center justify-center text-gray-900">
                                <p class="text-3xl font-semibold">02.35</p>
                                <p class="text-xs text-gray-500">Work Time</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-center gap-3 text-xs text-gray-600">
                        <button class="w-9 h-9 rounded-full bg-gray-900 text-white flex items-center justify-center">▶</button>
                        <button class="w-9 h-9 rounded-full border border-gray-300 flex items-center justify-center">⏸</button>
                        <button class="w-9 h-9 rounded-full border border-gray-300 flex items-center justify-center">⏹</button>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-span-3 space-y-5">
                <div class="lite-card p-5 space-y-4">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs text-gray-500">Onboarding</p>
                            <p class="text-3xl font-semibold text-gray-900">18%</p>
                        </div>
                        <div class="text-[10px] text-gray-500 space-y-1">
                            <div class="flex items-center gap-2">
                                <span>30%</span><span class="inline-block w-3 h-3 rounded-full bg-amber-300"></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span>25%</span><span class="inline-block w-3 h-3 rounded-full bg-gray-900"></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span>0%</span><span class="inline-block w-3 h-3 rounded-full bg-gray-400"></span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 text-xs">
                        <button class="flex-1 py-1.5 rounded-full bg-amber-300 text-gray-900 font-semibold">Task</button>
                        <button class="flex-1 py-1.5 rounded-full bg-gray-900 text-white">Team</button>
                        <button class="flex-1 py-1.5 rounded-full bg-gray-400 text-white">Other</button>
                    </div>
                </div>

                <div class="dark-task-card p-6 text-white">
                    <div class="flex items-center justify-between text-sm mb-4">
                        <p>Onboarding Task</p>
                        <p class="text-gray-400">2/8</p>
                    </div>
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center gap-3">
                            <span class="w-5 h-5 rounded-full border border-gray-500"></span>
                            <div>
                                <p>Interview</p>
                                <p class="text-[11px] text-gray-400">Sep 13 · 08:30</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="w-5 h-5 rounded-full bg-amber-300 text-gray-900 text-xs flex items-center justify-center">✓</span>
                            <div>
                                <p>Team Meeting</p>
                                <p class="text-[11px] text-gray-400">Sep 13 · 10:30</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="w-5 h-5 rounded-full border border-gray-500"></span>
                            <div>
                                <p>Project Update</p>
                                <p class="text-[11px] text-gray-400">Sep 14 · 09:00</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="w-5 h-5 rounded-full border border-gray-500"></span>
                            <div>
                                <p>Discuss Q3 Goals</p>
                                <p class="text-[11px] text-gray-400">Sep 15 · 14:45</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="w-5 h-5 rounded-full border border-gray-500"></span>
                            <div>
                                <p>HR Policy Review</p>
                                <p class="text-[11px] text-gray-400">Sep 16 · 16:30</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Calendar Row -->
        <div class="lite-card p-6">
            <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                <div class="flex items-center gap-2">
                    <button class="px-3 py-1 rounded-full bg-gray-900 text-white text-xs">August</button>
                    <span class="text-gray-400">September 2024</span>
                    <button class="px-3 py-1 rounded-full bg-gray-200 text-xs">October</button>
                </div>
                <div class="flex items-center gap-3 text-xs">
                    <span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span><span>Sun</span>
                </div>
            </div>
            <div class="calendar-grid grid grid-cols-7 gap-1 text-center text-sm text-gray-600 mb-6">
                <span>22</span>
                <span>23</span>
                <span class="bg-gray-900 text-white">24</span>
                <span>25</span>
                <span>26</span>
                <span>27</span>
                <span>28</span>
            </div>
            <div class="flex items-center justify-between text-xs text-gray-600">
                <div>
                    <p class="text-gray-400 mb-1">8:00 am</p>
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-gray-900 text-white">
                        <span>Weekly Team Sync</span>
                        <span class="w-6 h-6 rounded-full bg-amber-300 text-gray-900 flex items-center justify-center text-[10px]">+3</span>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-gray-400 mb-1">13:00 pm</p>
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-amber-100 text-gray-900">
                        <span>Onboarding Session</span>
                        <span class="w-6 h-6 rounded-full bg-gray-900 text-amber-200 flex items-center justify-center text-[10px]">+2</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
