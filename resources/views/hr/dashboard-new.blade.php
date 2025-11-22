<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR Dashboard – Crextio Replica</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-start: #f3f2ee;
            --bg-end: #f8dc8c;
            --text-dark: #111115;
            --text-muted: #7b7b7b;
            --card-bg: rgba(255,255,255,0.92);
            --card-shadow: 0 28px 48px rgba(0,0,0,0.08);
            --radius-lg: 34px;
            --radius-md: 22px;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, var(--bg-start) 0%, #f0e5d1 45%, var(--bg-end) 100%);
            color: var(--text-dark);
        }
        .dashboard-shell {
            max-width: 1150px;
            margin: 0 auto;
            padding: 32px 28px 60px;
        }
        .top-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 28px;
        }
        .brand-pill {
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .brand-pill span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 54px;
            height: 54px;
            border-radius: 16px;
            background: radial-gradient(circle at 30% 30%, #ffffff 0%, #d2d1d6 60%, #555770 100%);
            font-weight: 600;
            color: #0d0d0f;
        }
        .nav-tabs {
            background: rgba(255,255,255,0.6);
            border-radius: 999px;
            padding: 6px;
            display: flex;
            gap: 4px;
            box-shadow: inset 0 1px 2px rgba(255,255,255,0.6), 0 8px 18px rgba(0,0,0,0.08);
        }
        .nav-tabs button {
            border: none;
            background: transparent;
            padding: 8px 18px;
            border-radius: 999px;
            font-size: 0.72rem;
            color: #666;
            cursor: pointer;
        }
        .nav-tabs button.active {
            background: #11121A;
            color: #fff;
            font-weight: 600;
        }
        .nav-actions {
            display: flex;
            gap: 10px;
        }
        .nav-actions button {
            width: 40px;
            height: 40px;
            border-radius: 999px;
            border: 1px solid #d7d5d1;
            background: rgba(255,255,255,0.7);
            font-size: 0.8rem;
            cursor: pointer;
        }
        .hero {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 24px;
            margin-bottom: 26px;
        }
        .hero h1 {
            font-size: 3rem;
            margin: 0;
            letter-spacing: -0.02em;
        }
        .hero-label {
            text-transform: uppercase;
            letter-spacing: 0.35em;
            font-size: 0.65rem;
            color: var(--text-muted);
            margin-bottom: 8px;
        }
        .metric-row {
            display: flex;
            align-items: flex-end;
            gap: 28px;
        }
        .metric {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .metric-icon {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            background: rgba(0,0,0,0.08);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .metric-number {
            font-size: 3rem;
            font-weight: 600;
            letter-spacing: -0.04em;
            margin: 0;
        }
        .metric-label {
            text-transform: uppercase;
            letter-spacing: 0.22em;
            font-size: 0.6rem;
            color: var(--text-muted);
        }
        .status-row {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 14px;
            margin-bottom: 32px;
        }
        .pill-dark { background: #11121a; color: #fff; }
        .pill-gold { background: #f3d16c; color: #2f2100; }
        .pill-light { background: #dfdad1; color: #4a4a4a; }
        .status-pill {
            border-radius: 999px;
            padding: 8px 22px;
            font-weight: 600;
            font-size: 0.85rem;
            box-shadow: inset 0 1px 1px rgba(255,255,255,0.35);
        }
        .striped-pill {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 10px 22px;
            border-radius: 999px;
            background: #dcd6cd;
            font-weight: 600;
            font-size: 0.85rem;
            color: #5f5b55;
        }
        .striped-pill span.bar {
            width: 180px;
            height: 12px;
            border-radius: 999px;
            background: #c4bbaf;
            position: relative;
            overflow: hidden;
        }
        .striped-pill span.bar::after {
            content: '';
            position: absolute;
            inset: 0;
            background: repeating-linear-gradient(135deg, rgba(255,255,255,0.75) 0, rgba(255,255,255,0.75) 9px, transparent 9px, transparent 18px);
        }
        .main-grid {
            display: grid;
            grid-template-columns: 1.6fr 1.2fr 0.9fr;
            gap: 24px;
        }
        .card {
            border-radius: var(--radius-lg);
            background: var(--card-bg);
            box-shadow: var(--card-shadow);
            padding: 26px;
        }
        .profile-card {
            display: flex;
            gap: 22px;
            align-items: stretch;
        }
        .profile-card .photo {
            flex: 1;
            border-radius: 30px;
            background-size: cover;
            background-position: center;
            min-height: 260px;
        }
        .profile-meta {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .salary-pill {
            align-self: flex-start;
            padding: 10px 26px;
            background: linear-gradient(135deg, #e2c590, #c0874f);
            border-radius: 999px;
            color: #fff;
            font-weight: 600;
            box-shadow: 0 12px 25px rgba(0,0,0,0.15);
        }
        .detail-list {
            display: grid;
            gap: 14px;
            font-size: 0.9rem;
        }
        .detail-list .item {
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid rgba(0,0,0,0.06);
            padding-bottom: 10px;
        }
        .progress-card {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }
        .progress-bars {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            height: 140px;
        }
        .progress-bars .bar {
            width: 18px;
            border-radius: 18px;
            background: linear-gradient(180deg, #11121a, #585c66);
            position: relative;
        }
        .progress-bars .bar.gold {
            width: 24px;
            background: linear-gradient(180deg, #f7d35f, #c59a1c);
        }
        .progress-bars span {
            position: absolute;
            bottom: -22px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 0.75rem;
            color: var(--text-muted);
        }
        .time-card {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }
        .dial {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            position: relative;
            margin: 0 auto;
        }
        .dial svg {
            width: 100%;
            height: 100%;
        }
        .dial .center-text {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }
        .time-controls {
            display: flex;
            justify-content: center;
            gap: 12px;
        }
        .time-controls button {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            border: 1px solid #d4d1cd;
            background: #fff;
            font-size: 0.85rem;
        }
        .time-controls button.play {
            background: #11121a;
            color: #fff;
        }
        .onboarding-card {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .onboarding-stats {
            font-size: 0.75rem;
            color: var(--text-muted);
        }
        .toggle-row {
            display: flex;
            gap: 10px;
        }
        .toggle-row button {
            flex: 1;
            border: none;
            border-radius: 999px;
            padding: 8px 0;
            font-size: 0.8rem;
            cursor: pointer;
        }
        .toggle-row button.primary {
            background: #f3d16c;
            color: #332200;
            font-weight: 600;
        }
        .toggle-row button.dark { background: #11121a; color: #fff; }
        .toggle-row button.gray { background: #c4c1bd; color: #4d4b4c; }
        .task-card {
            border-radius: 40px;
            padding: 26px;
            background: linear-gradient(180deg, #11131a 0%, #07070c 100%);
            color: #fff;
            box-shadow: 0 40px 55px rgba(0,0,0,0.35);
        }
        .task-card .task {
            display: flex;
            gap: 12px;
            align-items: center;
            margin-bottom: 12px;
        }
        .task-card .task:last-child { margin-bottom: 0; }
        .task-card .dot {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,0.45);
        }
        .task-card .dot.done {
            background: #f3d16c;
            border-color: #f3d16c;
        }
        .calendar-card {
            margin-top: 28px;
            border-radius: var(--radius-lg);
            background: var(--card-bg);
            box-shadow: var(--card-shadow);
            padding: 28px;
        }
        .calendar-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
            font-size: 0.85rem;
            color: var(--text-muted);
        }
        .calendar-days {
            display: grid;
            grid-template-columns: repeat(7, minmax(0,1fr));
            gap: 6px;
            text-align: center;
            font-size: 0.9rem;
            color: #5b5b5b;
        }
        .calendar-days span {
            padding: 6px 0;
            border-radius: 18px;
        }
        .calendar-days span.active {
            background: #11121a;
            color: #fff;
        }
        .schedule-row {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            font-size: 0.78rem;
            color: #5f5f5f;
        }
        .chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 999px;
            font-size: 0.75rem;
            margin-top: 6px;
        }
        .chip.dark {
            background: #11121a;
            color: #fff;
        }
        .chip.gold {
            background: #f4e2b3;
            color: #2d2d2d;
        }
        @media (max-width: 1100px) {
            .main-grid { grid-template-columns: 1fr; }
            .profile-card { flex-direction: column; }
            .profile-card .photo { width: 100%; min-height: 200px; }
        }
    </style>
</head>
<body>
    <div class="dashboard-shell">
        <header class="top-bar">
            <div class="brand-pill">
                <span>C</span>
                <div>
                    <strong style="font-size:1.15rem">Crextio</strong><br>
                    <small style="color:#6d6d6d">People Platform</small>
                </div>
            </div>
            <nav class="nav-tabs">
                <button class="active">Dashboard</button>
                <button>People</button>
                <button>Hiring</button>
                <button>Devices</button>
                <button>Apps</button>
                <button>Salary</button>
                <button>Calendar</button>
                <button>Reviews</button>
                <button>Setting</button>
            </nav>
            <div class="nav-actions">
                <button>?</button>
                <button>🔔</button>
                <button>OP</button>
            </div>
        </header>

        <section class="hero">
            <div>
                <p class="hero-label">Dashboard</p>
                <h1>Welcome in, Nixtio</h1>
            </div>
            <div class="metric-row">
                <div class="metric">
                    <div class="metric-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#333" stroke-width="1.6"><path d="M17 20v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M20 8v6"/><path d="M22 11h-4"/></svg>
                    </div>
                    <div>
                        <p class="metric-number">78</p>
                        <p class="metric-label">Employee</p>
                    </div>
                </div>
                <div class="metric">
                    <div class="metric-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#333" stroke-width="1.6"><path d="M16 14v-2a4 4 0 0 0-8 0v2"/><circle cx="12" cy="7" r="4"/><path d="M22 11h-4"/><path d="M20 9v4"/></svg>
                    </div>
                    <div>
                        <p class="metric-number">56</p>
                        <p class="metric-label">Hirings</p>
                    </div>
                </div>
                <div class="metric">
                    <div class="metric-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#333" stroke-width="1.6"><path d="M9 17l3 3L22 7"/><path d="M2 12h7l3-8 4 12h6"/></svg>
                    </div>
                    <div>
                        <p class="metric-number">203</p>
                        <p class="metric-label">Projects</p>
                    </div>
                </div>
            </div>
        </section>

        <div class="status-row">
            <div class="status-pill pill-dark">Interviews · 15%</div>
            <div class="status-pill pill-gold">Hired · 15%</div>
            <div class="striped-pill">
                <span>Project time</span>
                <span class="bar"></span>
                <span>60%</span>
            </div>
            <div class="status-pill pill-light">Output · 10%</div>
        </div>

        <div class="main-grid">
            <div style="display:flex; flex-direction:column; gap:22px;">
                <div class="card profile-card">
                    <div class="photo" style="background-image:url('https://images.pexels.com/photos/1181686/pexels-photo-1181686.jpeg?auto=compress&cs=tinysrgb&w=800');"></div>
                    <div class="profile-meta">
                        <div>
                            <h2 style="margin:0; font-size:1.5rem;">Lora Piterson</h2>
                            <p style="margin:4px 0 0; color:#6d6d6d;">UX/UI Designer</p>
                        </div>
                        <div class="salary-pill">$1,200</div>
                    </div>
                </div>
                <div class="card">
                    <div class="detail-list">
                        <div class="item"><span>Pension contributions</span><strong>Updated 2024</strong></div>
                        <div class="item"><span>Devices</span><strong>MacBook Air · M1</strong></div>
                        <div class="item"><span>Compensation Summary</span><strong>Annual Review</strong></div>
                        <div class="item" style="border-bottom:none; padding-bottom:0;"><span>Employee Benefits</span><strong>Health · Dental · PTO</strong></div>
                    </div>
                </div>
            </div>

            <div style="display:flex; flex-direction:column; gap:22px;">
                <div class="card progress-card">
                    <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                        <div>
                            <p style="margin:0; color:#84827b;">Progress</p>
                            <h3 style="margin:6px 0 0; font-size:2.6rem;">6.1 h</h3>
                            <small style="color:#b1aea5;">Work Time this week</small>
                        </div>
                        <div style="text-align:right;">
                            <span style="display:inline-block; padding:6px 16px; border-radius:999px; background:#11121a; color:#fff; font-size:0.7rem;">5h 25m</span>
                        </div>
                    </div>
                    <div class="progress-bars">
                        <div class="bar" style="height:70px;"><span>M</span></div>
                        <div class="bar" style="height:90px;"><span>T</span></div>
                        <div class="bar" style="height:110px;"><span>W</span></div>
                        <div class="bar gold" style="height:130px;"><span>F</span></div>
                        <div class="bar" style="height:95px;"><span>S</span></div>
                        <div class="bar" style="height:60px;"><span>S</span></div>
                    </div>
                </div>
                <div class="card time-card">
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <div>
                            <p style="margin:0; color:#84827b;">Time tracker</p>
                            <small style="color:#b1aea5;">Work time</small>
                        </div>
                        <button style="border:none; background:#fff; width:34px; height:34px; border-radius:50%; box-shadow:0 5px 12px rgba(0,0,0,0.15);">↗</button>
                    </div>
                    <div class="dial">
                        <svg viewBox="0 0 120 120">
                            <circle cx="60" cy="60" r="50" stroke="#ede8df" stroke-width="10" fill="none" />
                            <circle cx="60" cy="60" r="50" stroke="#f4c957" stroke-width="10" fill="none" stroke-dasharray="280" stroke-dashoffset="90" stroke-linecap="round" />
                        </svg>
                        <div class="center-text">
                            <span style="font-size:2.4rem;">02.35</span>
                            <small style="color:#8a867d;">Work Time</small>
                        </div>
                    </div>
                    <div class="time-controls">
                        <button class="play">▶</button>
                        <button>⏸</button>
                        <button>⏹</button>
                    </div>
                </div>
            </div>

            <div style="display:flex; flex-direction:column; gap:22px;">
                <div class="card onboarding-card">
                    <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                        <div>
                            <p style="margin:0; color:#84827b;">Onboarding</p>
                            <h3 style="margin:4px 0 0; font-size:2.4rem;">18%</h3>
                        </div>
                        <div class="onboarding-stats">
                            <div>30% <span style="display:inline-block;width:10px;height:10px;border-radius:50%;background:#f3d16c;"></span></div>
                            <div>25% <span style="display:inline-block;width:10px;height:10px;border-radius:50%;background:#11121a;"></span></div>
                            <div>0% <span style="display:inline-block;width:10px;height:10px;border-radius:50%;background:#bcb7b0;"></span></div>
                        </div>
                    </div>
                    <div class="toggle-row">
                        <button class="primary">Task</button>
                        <button class="dark">Team</button>
                        <button class="gray">Other</button>
                    </div>
                </div>
                <div class="task-card">
                    <div style="display:flex; justify-content:space-between; margin-bottom:16px;">
                        <strong>Onboarding Task</strong>
                        <span style="color:#b8b7ba;">2 / 8</span>
                    </div>
                    <div class="task"><span class="dot"></span><div><div>Interview</div><small style="color:#b8b7ba;">Sep 13 · 08:30</small></div></div>
                    <div class="task"><span class="dot done"></span><div><div>Team Meeting</div><small style="color:#b8b7ba;">Sep 13 · 10:30</small></div></div>
                    <div class="task"><span class="dot"></span><div><div>Project Update</div><small style="color:#b8b7ba;">Sep 14 · 09:00</small></div></div>
                    <div class="task"><span class="dot"></span><div><div>Discuss Q3 Goals</div><small style="color:#b8b7ba;">Sep 15 · 14:45</small></div></div>
                    <div class="task"><span class="dot"></span><div><div>HR Policy Review</div><small style="color:#b8b7ba;">Sep 16 · 16:30</small></div></div>
                </div>
            </div>
        </div>

        <div class="calendar-card">
            <div class="calendar-header">
                <div style="display:flex; gap:10px; align-items:center;">
                    <button style="border:none; background:#11121a; color:#fff; border-radius:999px; padding:6px 16px; font-size:0.75rem;">August</button>
                    <strong>September 2024</strong>
                    <button style="border:none; background:#e9e4d9; color:#5a5a5a; border-radius:999px; padding:6px 16px; font-size:0.75rem;">October</button>
                </div>
                <div style="display:flex; gap:12px; font-size:0.8rem;">
                    <span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span><span>Sun</span>
                </div>
            </div>
            <div class="calendar-days">
                <span>22</span>
                <span>23</span>
                <span class="active">24</span>
                <span>25</span>
                <span>26</span>
                <span>27</span>
                <span>28</span>
            </div>
            <div class="schedule-row">
                <div>
                    <p>8:00 am</p>
                    <div class="chip dark">Weekly Team Sync <span style="background:#f3d16c; color:#111; border-radius:50%; width:22px; height:22px; display:inline-flex; align-items:center; justify-content:center;">+3</span></div>
                </div>
                <div style="text-align:right;">
                    <p>13:00 pm</p>
                    <div class="chip gold">Onboarding Session <span style="background:#111; color:#f3d16c; border-radius:50%; width:22px; height:22px; display:inline-flex; align-items:center; justify-content:center;">+2</span></div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
