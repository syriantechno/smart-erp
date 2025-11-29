@extends('../themes/base')

@section('head')
    <title>Sign In - Smart ERP</title>
    @push('styles')
        <style>
            .auth-shell {
                min-height: 100vh;
                background: linear-gradient(135deg, #fff5d7 0%, #ffe9a9 35%, #f9f2e8 65%, #f1f1f1 100%);
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 2rem 1.5rem;
            }

            .auth-card {
                width: 100%;
                max-width: 1200px;
                border-radius: 32px;
                background: #fff;
                box-shadow: 0 25px 80px rgba(15, 23, 42, 0.12);
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
                overflow: hidden;
            }

            .auth-form-panel {
                padding: clamp(2rem, 4vw, 3.5rem);
                background: linear-gradient(180deg, rgba(255,255,255,0.95), rgba(255,255,255,0.9));
            }

            .auth-form-title {
                font-size: clamp(1.5rem, 2.5vw, 2rem);
                font-weight: 700;
                color: #0f172a;
            }

            .auth-form-subtitle {
                color: #475569;
                font-size: 0.95rem;
                margin-top: 0.5rem;
            }

            .auth-input {
                width: 100%;
                padding: 0.9rem 1.1rem;
                border-radius: 16px;
                border: 1px solid #e2e8f0;
                background: #f8fafc;
                transition: border-color 0.2s ease, box-shadow 0.2s ease;
            }

            .auth-input:focus {
                border-color: #f4c15b;
                box-shadow: 0 8px 30px rgba(251, 191, 36, 0.25);
                background: #fff;
            }

            .auth-submit {
                width: 100%;
                border-radius: 24px;
                padding: 0.95rem;
                background: linear-gradient(90deg, #ffd977, #f6b756);
                border: none;
                color: #1f2937;
                font-weight: 600;
                font-size: 1rem;
                box-shadow: 0 18px 30px rgba(247, 180, 84, 0.35);
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }

            .auth-submit:hover {
                transform: translateY(-2px);
                box-shadow: 0 25px 35px rgba(247, 180, 84, 0.45);
            }

            .auth-social-buttons {
                display: flex;
                gap: 0.75rem;
                margin-top: 1rem;
            }

            .auth-social-button {
                flex: 1;
                border: 1px solid #e2e8f0;
                border-radius: 18px;
                padding: 0.85rem;
                background: #fff;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 0.5rem;
                font-weight: 500;
                color: #0f172a;
            }

            .auth-hero-panel {
                position: relative;
                border-radius: 0;
                background: linear-gradient(125deg, rgba(0,0,0,0.45), rgba(0,0,0,0.25)), url('{{ Vite::asset('resources/images/fakers/preview-2.jpg') }}');
                background-size: cover;
                background-position: center;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: clamp(2rem, 4vw, 3.5rem);
                overflow: hidden;
            }

            .auth-hero-panel::before {
                content: '';
                position: absolute;
                inset: 0;
                background: linear-gradient(135deg, rgba(255,245,215,0.1), rgba(255,233,169,0.35));
            }

            .auth-hero-panel::after {
                content: '';
                position: absolute;
                width: 500px;
                height: 500px;
                background: radial-gradient(circle, rgba(255,255,255,0.4) 0%, rgba(255,255,255,0) 70%);
                bottom: -10%;
                right: -5%;
            }

            .auth-pill {
                position: absolute;
                background: #fff;
                border-radius: 20px;
                padding: 0.75rem 1.1rem;
                box-shadow: 0 20px 50px rgba(15,23,42,0.25);
                display: flex;
                align-items: center;
                gap: 0.5rem;
                font-size: 0.85rem;
                color: #0f172a;
            }

            .auth-pill--yellow {
                background: #f9d35b;
                color: #111827;
            }

            .auth-calendar {
                position: absolute;
                bottom: 2rem;
                left: 50%;
                transform: translateX(-50%);
                width: 85%;
                background: rgba(17, 26, 38, 0.85);
                border-radius: 22px;
                padding: 1.5rem;
                color: #f8fafc;
                backdrop-filter: blur(12px);
                box-shadow: 0 20px 60px rgba(0,0,0,0.5);
            }

            @media (max-width: 1024px) {
                .auth-card {
                    border-radius: 24px;
                }

                .auth-hero-panel {
                    min-height: 420px;
                }
            }
        </style>
    @endpush
@endsection

@section('content')
    <div class="auth-shell">
        <div class="auth-card">
            <div class="auth-form-panel">
                <div class="mb-8">
                    <img src="{{ Vite::asset('resources/images/logo.svg') }}" alt="Smart ERP" class="h-8">
                </div>
                <div>
                    <p class="text-sm uppercase tracking-[0.2em] text-slate-500">Welcome back</p>
                    <h1 class="auth-form-title mt-2">Sign In</h1>
                    <p class="auth-form-subtitle">Enter your credentials to access your account</p>
                </div>

                @if($errors->any())
                    <div class="mt-8 rounded-2xl border border-red-100 bg-red-50/70 p-4 text-sm text-red-600">
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-4">
                    @csrf
                    <div>
                        <label class="text-sm font-medium text-slate-600">Email</label>
                        <input type="email" class="auth-input mt-2" name="email" value="{{ old('email') }}" placeholder="Enter your email" required autofocus>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-slate-600">Password</label>
                        <div class="relative mt-2">
                            <input type="password" class="auth-input pr-12" name="password" placeholder="••••••••" required>
                            <span class="absolute inset-y-0 right-4 flex items-center text-slate-400 text-sm">👁</span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-sm text-slate-500">
                        <label class="inline-flex items-center gap-2">
                            <input type="checkbox" name="remember" class="h-4 w-4 rounded border-slate-300 text-amber-400 focus:ring-amber-300">
                            Remember me
                        </label>
                        <a href="{{ route('password.request') }}" class="font-medium text-amber-500">Forgot password?</a>
                    </div>

                    <button type="submit" class="auth-submit">Login</button>

                    <div class="text-center text-sm text-slate-400">or continue with</div>

                    <div class="auth-social-buttons">
                        <button type="button" class="auth-social-button">
                            <img src="{{ Vite::asset('resources/images/icons/apple.svg') }}" alt="Apple" class="h-5">
                            Apple
                        </button>
                        <button type="button" class="auth-social-button">
                            <img src="{{ Vite::asset('resources/images/icons/google.svg') }}" alt="Google" class="h-5">
                            Google
                        </button>
                    </div>
                </form>

                <div class="mt-10 flex flex-wrap items-center justify-between text-sm text-slate-400">
                    <span>Don't have an account? <a href="{{ route('register') }}" class="text-slate-700 font-semibold">Sign up</a></span>
                    <div class="flex gap-4">
                        <a href="#" class="underline">Terms & Conditions</a>
                        <a href="#" class="underline">Privacy Policy</a>
                    </div>
                </div>
            </div>

            <div class="auth-hero-panel">
                <div class="auth-pill auth-pill--yellow" style="top: 16%; left: 15%;">
                    <span class="text-xs uppercase tracking-[0.2em]">Task Review With Team</span>
                    <span class="text-sm font-semibold">02:30pm - 03:00pm</span>
                </div>

                <div class="auth-pill" style="top: 35%; right: 12%;">
                    <div class="flex items-center -space-x-3">
                        @foreach([14,11,6] as $avatar)
                            <img src="{{ Vite::asset('resources/images/fakers/profile-' . $avatar . '.jpg') }}" class="h-8 w-8 rounded-full border-2 border-white" alt="team member">
                        @endforeach
                    </div>
                    <span class="text-sm font-semibold">Daily Meeting</span>
                </div>

                <div class="auth-calendar">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm uppercase tracking-[0.3em] text-slate-400">March</p>
                            <h3 class="text-2xl font-semibold">24 - 30</h3>
                        </div>
                        <span class="text-amber-300 text-sm">Weekly Schedule</span>
                    </div>
                    <div class="mt-6 grid grid-cols-7 gap-2 text-center text-sm text-slate-300">
                        @foreach(['Sun','Mon','Tue','Wed','Thu','Fri','Sat'] as $day)
                            <div class="py-2 rounded-2xl {{ $day === 'Wed' ? 'bg-amber-400 text-gray-900 font-semibold' : 'bg-white/5' }}">{{ $day }}</div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
