@extends('../themes/base')

@section('head')
    <title>Sign In - Smart ERP</title>
    @push('styles')
        <style>
            .auth-container {
                min-height: 100vh;
                display: grid;
                grid-template-columns: 1fr 1fr;
            }

            .auth-form-side {
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                padding: 3rem 4rem;
            }

            .auth-form-wrapper {
                max-width: 380px;
                width: 100%;
            }

            .auth-logo {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                margin-bottom: 3rem;
            }

            .auth-logo-icon {
                width: 32px;
                height: 32px;
            }

            .auth-logo-text {
                font-size: 1.25rem;
                font-weight: 700;
                color: #0f172a;
                letter-spacing: -0.02em;
            }

            .auth-form-title {
                font-size: 1.75rem;
                font-weight: 600;
                color: #0f172a;
                margin-bottom: 0.5rem;
            }

            .auth-form-subtitle {
                color: #64748b;
                font-size: 0.9rem;
                margin-bottom: 2rem;
            }

            .auth-input-group {
                margin-bottom: 1.25rem;
            }

            .auth-input-label {
                display: block;
                font-size: 0.8rem;
                color: #94a3b8;
                margin-bottom: 0.5rem;
                font-weight: 500;
            }

            .auth-input {
                width: 100%;
                padding: 0.875rem 1rem !important;
                border-radius: 12px !important;
                border: 1px solid #e2e8f0 !important;
                background: #fff !important;
                font-size: 0.95rem;
                color: #0f172a;
                transition: box-shadow 0.2s ease, border-color 0.2s ease;
            }

            .auth-input::placeholder {
                color: #94a3b8;
            }

            .auth-input:focus {
                outline: none;
                box-shadow: 0 0 0 2px rgba(251, 191, 36, 0.3);
                background: #fff;
            }

            .auth-input-password {
                position: relative;
            }

            .auth-input-password .auth-input {
                padding-right: 3rem;
            }

            .auth-password-toggle {
                position: absolute;
                right: 1rem;
                top: 50%;
                transform: translateY(-50%);
                background: none;
                border: none;
                cursor: pointer;
                color: #94a3b8;
                padding: 0.25rem;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .auth-password-toggle:hover {
                color: #64748b;
            }

            .auth-submit {
                width: 100%;
                border-radius: 50px;
                padding: 0.875rem;
                background: linear-gradient(90deg, #fcd34d, #f59e0b);
                border: none;
                color: #1f2937;
                font-weight: 600;
                font-size: 1rem;
                cursor: pointer;
                transition: transform 0.2s ease, box-shadow 0.2s ease;
                margin-top: 0.5rem;
            }

            .auth-submit:hover {
                transform: translateY(-1px);
                box-shadow: 0 10px 25px rgba(245, 158, 11, 0.3);
            }

            .auth-social-buttons {
                display: flex;
                gap: 0.75rem;
                margin-top: 1.5rem;
            }

            .auth-social-button {
                flex: 1;
                border: 1px solid #e2e8f0;
                border-radius: 50px;
                padding: 0.75rem;
                background: #fff;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 0.5rem;
                font-weight: 500;
                font-size: 0.9rem;
                color: #0f172a;
                cursor: pointer;
                transition: background 0.2s ease, border-color 0.2s ease;
            }

            .auth-social-button:hover {
                background: #f8fafc;
                border-color: #cbd5e1;
            }

            .auth-footer {
                margin-top: 2.5rem;
                display: flex;
                justify-content: space-between;
                align-items: center;
                font-size: 0.85rem;
                color: #94a3b8;
            }

            .auth-footer a {
                color: #64748b;
                text-decoration: underline;
            }

            .auth-footer a.signup-link {
                color: #0f172a;
                font-weight: 600;
                text-decoration: underline;
            }

            /* Hero Side */
            .auth-hero-side {
                position: relative;
                background: url('{{ Vite::asset('resources/images/fakers/login.jpg') }}');
                background-size: cover;
                background-position: center;
                overflow: hidden;
                margin: 1.5rem;
                border-radius: 2rem;
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            }

            .auth-hero-side::before {
                display: none;
            }

            .auth-close-btn {
                position: absolute;
                top: 1.5rem;
                right: 1.5rem;
                width: 40px;
                height: 40px;
                border-radius: 50%;
                background: rgba(255,255,255,0.95);
                border: none;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                z-index: 10;
                transition: background 0.2s ease;
            }

            .auth-close-btn:hover {
                background: #fff;
            }

            .auth-pill {
                position: absolute;
                background: #fff;
                border-radius: 16px;
                padding: 0.75rem 1rem;
                box-shadow: 0 10px 40px rgba(0,0,0,0.15);
                z-index: 5;
            }

            .auth-pill--yellow {
                background: #fcd34d;
            }

            .auth-pill-title {
                font-weight: 600;
                font-size: 0.85rem;
                color: #0f172a;
            }

            .auth-pill-time {
                font-size: 0.7rem;
                color: #64748b;
                margin-top: 0.15rem;
            }

            .auth-pill--yellow .auth-pill-time {
                color: #92400e;
            }

            .auth-pill-dot {
                width: 6px;
                height: 6px;
                border-radius: 50%;
                background: #22c55e;
                position: absolute;
                top: 0.75rem;
                right: 0.75rem;
            }

            .auth-avatars-group {
                position: absolute;
                display: flex;
                flex-direction: column;
                gap: 0.5rem;
                z-index: 5;
            }

            .auth-avatar {
                width: 44px;
                height: 44px;
                border-radius: 50%;
                border: 3px solid #fff;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                object-fit: cover;
            }

            .auth-calendar-card {
                position: absolute;
                bottom: 5%;
                left: 50%;
                transform: translateX(-50%);
                background: #fff;
                border-radius: 20px;
                padding: 1.25rem;
                box-shadow: 0 15px 50px rgba(0,0,0,0.2);
                z-index: 5;
                min-width: 340px;
            }

            .auth-calendar-days {
                display: flex;
                gap: 0.25rem;
                margin-bottom: 1rem;
            }

            .auth-calendar-day {
                text-align: center;
                padding: 0.5rem 0.25rem;
                flex: 1;
            }

            .auth-calendar-day-name {
                font-size: 0.65rem;
                color: #94a3b8;
                margin-bottom: 0.25rem;
            }

            .auth-calendar-day-num {
                font-size: 0.9rem;
                font-weight: 600;
                color: #0f172a;
            }

            .auth-calendar-day.active .auth-calendar-day-num {
                background: #fcd34d;
                color: #0f172a;
                width: 28px;
                height: 28px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto;
            }

            .auth-meeting-card {
                background: #fff;
                border: 1px solid #f1f5f9;
                border-radius: 14px;
                padding: 0.875rem;
                display: flex;
                align-items: center;
                gap: 0.75rem;
            }

            .auth-meeting-indicator {
                width: 4px;
                height: 36px;
                background: #fcd34d;
                border-radius: 2px;
            }

            .auth-meeting-info h4 {
                font-weight: 600;
                font-size: 0.85rem;
                color: #0f172a;
                margin: 0;
            }

            .auth-meeting-info p {
                font-size: 0.7rem;
                color: #94a3b8;
                margin: 0.15rem 0 0;
            }

            .auth-meeting-avatars {
                display: flex;
                margin-left: auto;
            }

            .auth-meeting-avatars img {
                width: 26px;
                height: 26px;
                border-radius: 50%;
                border: 2px solid #fff;
                margin-left: -8px;
                object-fit: cover;
            }

            .auth-meeting-avatars img:first-child {
                margin-left: 0;
            }

            @media (max-width: 1024px) {
                .auth-container {
                    grid-template-columns: 1fr;
                }

                .auth-hero-side {
                    display: none;
                }

                .auth-form-side {
                    padding: 2rem;
                    align-items: center;
                }
            }
        </style>
    @endpush
@endsection

@section('content')
    <div class="auth-container">
        <!-- Form Side -->
        <div class="auth-form-side">
            <div class="auth-form-wrapper">
                <div class="auth-logo">
                    <img src="{{ Vite::asset('resources/images/logo.svg') }}" alt="{{ config('app.name') }}" class="auth-logo-icon">
                    <span class="auth-logo-text">{{ config('app.name') }}</span>
                </div>

                <h1 class="auth-form-title">Sign In</h1>
                <p class="auth-form-subtitle">Enter your credentials to access your account</p>

                @if($errors->any())
                    <div class="mb-6 rounded-xl border border-red-100 bg-red-50/70 p-4 text-sm text-red-600">
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="auth-input-group">
                        <label class="auth-input-label">Email</label>
                        <input type="email" class="auth-input" name="email" value="{{ old('email') }}" placeholder="email@example.com" required autofocus>
                    </div>

                    <div class="auth-input-group">
                        <label class="auth-input-label">Password</label>
                        <div class="auth-input-password">
                            <input type="password" class="auth-input" name="password" id="password" placeholder="••••••••••••••••" required>
                            <button type="button" class="auth-password-toggle" onclick="togglePassword()">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/>
                                    <line x1="1" y1="1" x2="23" y2="23"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="auth-submit">Login</button>

                    <div class="auth-social-buttons">
                        <button type="button" class="auth-social-button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/>
                            </svg>
                            Apple
                        </button>
                        <button type="button" class="auth-social-button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24">
                                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                            </svg>
                            Google
                        </button>
                    </div>
                </form>

                <div class="auth-footer">
                    <span>Don't have an account? <a href="{{ route('register') }}" class="signup-link">Sign up</a></span>
                    <a href="#">Terms & Conditions</a>
                </div>
            </div>
        </div>

        <!-- Hero Side -->
        <div class="auth-hero-side">
            <button class="auth-close-btn" onclick="window.location.href='/'">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#0f172a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>

            <!-- Task Review Pill -->
            <div class="auth-pill auth-pill--yellow" style="top: 10%; left: 8%;">
                <span class="auth-pill-dot"></span>
                <span class="auth-pill-title">Task Review With Team</span>
                <span class="auth-pill-time">09:30am-10:00am</span>
            </div>

            <!-- Secondary Time Pill -->
            <div class="auth-pill" style="top: 14%; left: 55%;">
                <span class="auth-pill-time" style="color: #94a3b8;">09:30am-10:00am</span>
            </div>

            <!-- Avatars Group -->
            <div class="auth-avatars-group" style="top: 22%; right: 6%;">
                <img src="{{ Vite::asset('resources/images/fakers/profile-1.jpg') }}" class="auth-avatar" alt="Team member">
                <img src="{{ Vite::asset('resources/images/fakers/profile-2.jpg') }}" class="auth-avatar" alt="Team member">
                <img src="{{ Vite::asset('resources/images/fakers/profile-3.jpg') }}" class="auth-avatar" alt="Team member">
            </div>

            <!-- Calendar Card -->
            <div class="auth-calendar-card">
                <div class="auth-calendar-days">
                    <div class="auth-calendar-day">
                        <div class="auth-calendar-day-name">Sun</div>
                        <div class="auth-calendar-day-num">22</div>
                    </div>
                    <div class="auth-calendar-day">
                        <div class="auth-calendar-day-name">Mon</div>
                        <div class="auth-calendar-day-num">23</div>
                    </div>
                    <div class="auth-calendar-day">
                        <div class="auth-calendar-day-name">Tue</div>
                        <div class="auth-calendar-day-num">24</div>
                    </div>
                    <div class="auth-calendar-day active">
                        <div class="auth-calendar-day-name">Wed</div>
                        <div class="auth-calendar-day-num">25</div>
                    </div>
                    <div class="auth-calendar-day">
                        <div class="auth-calendar-day-name">Thu</div>
                        <div class="auth-calendar-day-num">26</div>
                    </div>
                    <div class="auth-calendar-day">
                        <div class="auth-calendar-day-name">Fri</div>
                        <div class="auth-calendar-day-num">27</div>
                    </div>
                    <div class="auth-calendar-day">
                        <div class="auth-calendar-day-name">Sat</div>
                        <div class="auth-calendar-day-num">28</div>
                    </div>
                </div>

                <div class="auth-meeting-card">
                    <div class="auth-meeting-indicator"></div>
                    <div class="auth-meeting-info">
                        <h4>Daily Meeting</h4>
                        <p>12:00pm-01:00pm</p>
                    </div>
                    <div class="auth-meeting-avatars">
                        <img src="{{ Vite::asset('resources/images/fakers/profile-4.jpg') }}" alt="Attendee">
                        <img src="{{ Vite::asset('resources/images/fakers/profile-5.jpg') }}" alt="Attendee">
                        <img src="{{ Vite::asset('resources/images/fakers/profile-6.jpg') }}" alt="Attendee">
                        <img src="{{ Vite::asset('resources/images/fakers/profile-7.jpg') }}" alt="Attendee">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
        }
    </script>
@endsection
