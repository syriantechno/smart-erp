

<?php $__env->startSection('subhead'); ?>
    <title>Projects Dashboard - Smart ERP</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('subcontent'); ?>
    <div class="mt-6 ml-1 sm:ml-2 md:ml-3 lg:ml-4">
        <h1 class="text-3xl sm:text-4xl font-semibold tracking-tight text-slate-900">
            Welcome in, <?php echo e(auth()->user()->name); ?>

        </h1>
        <div class="mt-3 flex items-center gap-3 text-sm text-slate-700">
            <div>
                <?php echo e(now()->format('l, F j, Y')); ?>

            </div>
            <div class="flex items-center gap-1 text-slate-600">
                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'sun','class' => 'w-4 h-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'sun','class' => 'w-4 h-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $attributes = $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $component = $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
                <span>26°C · Clear sky</span>
            </div>
        </div>

        <div class="mt-8 flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6">
            <div class="flex-1 flex flex-col gap-3">
                <div class="flex items-center gap-6 text-xs tracking-[0.24em] uppercase text-slate-600">
                    <span>Interviews</span>
                    <span>Hired</span>
                    <span>Project time</span>
                    <span>Output</span>
                </div>

                <div class="flex items-center gap-1.5 justify-start">
                    <button class="h-10 rounded-full px-10 flex items-center justify-center text-xs font-semibold text-white bg-[#303030]">15%</button>
                    <button class="h-10 rounded-full px-10 flex items-center justify-center text-xs font-semibold text-[#3a2a1a]" style="background: linear-gradient(to bottom,#f7e08a,#d49a24);">15%</button>

                    <div class="h-10 rounded-full flex items-center justify-center px-3 text-sm font-semibold text-slate-700">
                        <div class="relative w-[360px] h-10 rounded-full overflow-hidden flex items-center justify-center">
                            <div class="absolute inset-0 bg-[repeating-linear-gradient(135deg,rgba(255,255,255,0.8)_0,rgba(255,255,255,0.8)_10px,transparent_10px,transparent_20px)]"></div>
                            <span class="relative z-10 leading-none">60%</span>
                        </div>
                    </div>

                    <div class="h-10 rounded-full px-5 flex items-center justify-center text-xs font-semibold text-slate-700 border border-slate-400">10%</div>
                </div>
            </div>

            <div class="flex gap-10 text-right">
                <div>
                    <div class="flex items-baseline justify-end gap-2 text-[#3a2a1a]">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'users','class' => 'w-4 h-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'users','class' => 'w-4 h-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $attributes = $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $component = $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
                        </div>
                        <div class="text-7xl font-semibold tracking-tight">78</div>
                    </div>
                    <div class="mt-1 text-xs uppercase tracking-[0.25em] text-slate-600">Employee</div>
                </div>
                <div>
                    <div class="flex items-baseline justify-end gap-2 text-[#3a2a1a]">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'user-plus','class' => 'w-4 h-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'user-plus','class' => 'w-4 h-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $attributes = $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $component = $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
                        </div>
                        <div class="text-7xl font-semibold tracking-tight">56</div>
                    </div>
                    <div class="mt-1 text-xs uppercase tracking-[0.25em] text-slate-600">Hirings</div>
                </div>
                <div>
                    <div class="flex items-baseline justify-end gap-2 text-[#3a2a1a]">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'briefcase','class' => 'w-4 h-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'briefcase','class' => 'w-4 h-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $attributes = $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $component = $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
                        </div>
                        <div class="text-7xl font-semibold tracking-tight">203</div>
                    </div>
                    <div class="mt-1 text-xs uppercase tracking-[0.25em] text-slate-600">Projects</div>
                </div>
            </div>
        </div>

        <div class="mt-10 flex flex-row items-start gap-3 w-full">
            <div class="flex-1 flex flex-col gap-6">
                <div class="flex flex-row flex-nowrap items-start justify-start gap-2 w-full">
                    
                    <div class="flex-1 min-w-[260px] h-[280px] rounded-[32px] overflow-hidden bg-white/60 shadow-[0_24px_50px_rgba(15,15,20,0.12)] flex flex-col sm:flex-row">
                        <div class="sm:w-1/2 h-56 sm:h-64 bg-cover bg-center" style="background-image: url('https://images.pexels.com/photos/1181686/pexels-photo-1181686.jpeg?auto=compress&cs=tinysrgb&w=800');"></div>
                        <div class="sm:w-1/2 flex flex-col justify-between p-6">
                            <div>
                                <div class="text-2xl tracking-[0.25em] uppercase text-[#303030] mb-2">Projects</div>
                                <div class="text-xl font-semibold text-[#3a2a1a]"><?php echo e(auth()->user()->name); ?></div>
                                <div class="mt-1 text-sm text-slate-500">Project Owner</div>
                            </div>
                            <div class="mt-4 self-start rounded-full border border-white/70 bg-[#303030] text-slate-50 px-5 py-2 text-xs font-semibold">
                                $1,200 Budget
                            </div>
                        </div>
                    </div>

                    
                    <div class="flex-1 min-w-[260px] h-[280px] rounded-[32px] bg-white/60 shadow-[0_24px_50px_rgba(15,15,20,0.10)] p-6 flex flex-col justify-between">
                        <div class="flex items-start justify-between">
                            <div>
                                <div class="text-2xl text-[#303030]">Progress</div>
                                <div class="mt-2 text-3xl font-semibold text-[#3a2a1a]">6.1 h</div>
                                <div class="text-xs text-slate-500">Work time this week</div>
                            </div>
                            <button class="h-8 w-8 rounded-full border border-slate-200 flex items-center justify-center text-slate-500 text-xs">
                                ↗
                            </button>
                        </div>
                        <div class="mt-5 flex items-end justify-between h-28">
                            <?php $__currentLoopData = ['S','M','T','W','T','F','S']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $heights = [30,50,60,80,55,90,35];
                                    $isPeak = $i === 5;
                                ?>
                                <div class="flex flex-col items-center justify-end h-full">
                                    <?php if($isPeak): ?>
                                        <div class="w-3 rounded-full" style="height: <?php echo e($heights[$i]); ?>px; background: linear-gradient(to bottom,#f4cf60,#b5831d);"></div>
                                    <?php else: ?>
                                        <div class="w-3 rounded-full bg-[#3a2a1a]" style="height: <?php echo e($heights[$i]); ?>px"></div>
                                    <?php endif; ?>
                                    <span class="mt-2 text-[11px] text-[#3a2a1a]"><?php echo e($day); ?></span>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    
                    <div class="flex-1 min-w-[260px] h-[280px] rounded-[32px] bg-white/60 shadow-[0_24px_50px_rgba(15,15,20,0.10)] p-6 flex flex-col justify-between">
                        <div class="flex items-start justify-between">
                            <div class="text-2xl text-[#303030]">Time tracker</div>
                            <button class="h-8 w-8 rounded-full border border-slate-200 flex items-center justify-center text-slate-500 text-xs">↗</button>
                        </div>
                        <div class="mt-4 flex items_center justify-center">
                            <div class="relative w-40 h-40">
                                <svg viewBox="0 0 120 120" class="w-full h-full">
                                    <circle cx="60" cy="60" r="48" stroke="#ebe4d7" stroke-width="10" fill="none" />
                                    <circle cx="60" cy="60" r="48" stroke="#f7d46a" stroke-width="10" fill="none" stroke-dasharray="260" stroke-dashoffset="80" stroke-linecap="round" />
                                </svg>
                                <div class="absolute inset-0 flex flex-col items-center justify-center">
                                    <div class="text-3xl font-semibold text-[#3a2a1a]">02:35</div>
                                    <div class="mt-1 text-xs text-slate-500">Work Time</div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center justify-center gap-3 text-xs">
                            <button class="h-8 w-8 rounded-full border border-slate-300 flex items-center justify-center">▶</button>
                            <button class="h-8 w-8 rounded-full border border-slate-300 flex items-center justify-center">⏸</button>
                            <button class="h-8 w-8 rounded-full border border-[#303030] bg-[#303030] text-white flex items-center justify-center">⏱</button>
                        </div>
                    </div>
                </div>

                
                <div class="flex flex-row flex-nowrap items-start justify-start gap-2 w-full">
                    
                    <div class="flex-1 rounded-[32px] bg-white/60 shadow-[0_24px_50px_rgba(15,15,20,0.10)] p-6 flex flex-col gap-4 text-sm text-[#303030]">
                        <div class="flex items-center justify-between cursor-pointer">
                            <span class="font-semibold">Pension contributions</span>
                            <span class="text-xs text-slate-500">▼</span>
                        </div>
                        <div class="flex items-center justify-between cursor-pointer">
                            <span class="font-semibold">Devices</span>
                            <span class="text-xs text-slate-500">▼</span>
                        </div>
                        <div class="flex items-center gap-3 rounded-[24px] bg-white/80 shadow-[0_16px_40px_rgba(15,15,20,0.12)] p-3">
                            <div class="h-10 w-14 rounded-[18px] bg-cover bg-center" style="background-image: url('https://images.pexels.com/photos/18105/pexels-photo.jpg?auto=compress&cs=tinysrgb&w=400');"></div>
                            <div class="flex-1">
                                <div class="text-xs uppercase tracking-[0.22em] text-slate-500">MacBook Air</div>
                                <div class="text-[11px] text-slate-500">Version M1</div>
                            </div>
                            <span class="text-lg text-slate-400">⋯</span>
                        </div>
                        <div class="flex items-center justify-between cursor-pointer">
                            <span class="font-semibold">Compensation Summary</span>
                            <span class="text-xs text-slate-500">▼</span>
                        </div>
                        <div class="flex items-center justify-between cursor-pointer">
                            <span class="font-semibold">Employee Benefits</span>
                            <span class="text-xs text-slate-500">▼</span>
                        </div>
                    </div>

                    
                    <div class="flex-1 rounded-[32px] bg-white/70 shadow-[0_24px_50px_rgba(15,15,20,0.10)] px-6 pt-5 pb-6 flex flex-col gap-4">
                        <div class="flex items-center justify-between text-xs text-[#303030]">
                            <button class="px-3 py-1 rounded-full bg-white/70 text-[11px] shadow-sm">August</button>
                            <div class="text-sm font-semibold">September 2024</div>
                            <button class="px-3 py-1 rounded-full bg-white/70 text-[11px] shadow-sm">October</button>
                        </div>

                        <div class="mt-3 grid grid-cols-7 text-[11px] text-slate-500">
                            <div class="flex flex-col items-center gap-1">
                                <span>Mon</span>
                                <span class="text-[10px]">22</span>
                            </div>
                            <div class="flex flex-col items-center gap-1">
                                <span>Tue</span>
                                <span class="text-[10px]">23</span>
                            </div>
                            <div class="flex flex-col items-center gap-1">
                                <span>Wed</span>
                                <span class="text-[10px] font-semibold text-[#303030]">24</span>
                            </div>
                            <div class="flex flex-col items-center gap-1">
                                <span>Thu</span>
                                <span class="text-[10px]">25</span>
                            </div>
                            <div class="flex flex-col items-center gap-1">
                                <span>Fri</span>
                                <span class="text-[10px]">26</span>
                            </div>
                            <div class="flex flex-col items-center gap-1">
                                <span>Sat</span>
                                <span class="text-[10px]">27</span>
                            </div>
                            <div class="flex flex-col items-center gap-1">
                                <span>Sun</span>
                                <span class="text-[10px]">28</span>
                            </div>
                        </div>

                        <div class="mt-4 flex flex-col gap-3 text-[11px] text-slate-600">
                            <div class="relative h-10 flex items-center">
                                <div class="w-1/3 text-[10px] text-slate-500">8:00 am</div>
                                <div class="flex-1">
                                    <div class="inline-flex items-center rounded-[999px] bg-[#303030] text-slate-50 px-4 py-2 shadow-[0_16px_40px_rgba(15,15,20,0.45)]">
                                        <div>
                                            <div class="text-xs font-semibold">Weekly Team Sync</div>
                                            <div class="text-[10px] text-slate-300">Discuss progress on projects</div>
                                        </div>
                                        <div class="ml-3 flex -space-x-2">
                                            <span class="h-6 w-6 rounded-full bg-white/80 border border-white"></span>
                                            <span class="h-6 w-6 rounded-full bg-white/70 border border-white"></span>
                                            <span class="h-6 w-6 rounded-full bg-white/60 border border-white"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="relative h-10 flex items-center">
                                <div class="w-1/3 text-[10px] text-slate-500">11:00 am</div>
                                <div class="flex-1">
                                    <div class="inline-flex items-center rounded-[999px] bg-white px-4 py-2 shadow-[0_12px_30px_rgba(15,15,20,0.18)]">
                                        <div>
                                            <div class="text-xs font-semibold text-[#303030]">Onboarding Session</div>
                                            <div class="text-[10px] text-slate-500">Introduction for new hires</div>
                                        </div>
                                        <div class="ml-3 flex -space-x-2">
                                            <span class="h-6 w-6 rounded-full bg-slate-300 border border-white"></span>
                                            <span class="h-6 w-6 rounded-full bg-slate-200 border border-white"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="flex-none w-[320px] bg-white/60 rounded-[32px] shadow-[0_24px_50px_rgba(15,15,20,0.10)] px-4 pt-4 pb-5">
                <div class="px-1">
                    <div class="flex items-baseline justify-between text-2xl text-[#303030]">
                        <span>Onboarding</span>
                        <span class="text-base font-semibold tracking-tight">18%</span>
                    </div>

                    <div class="mt-3 flex items-end gap-0.5 text-[11px]">
                        
                        <div class="flex flex-col items-start gap-0.5">
                            <span>30%</span>
                            <button class="h-8 min-w-[88px] rounded-[10px] px-4 text-[11px] font-semibold text-[#3a2a1a] flex items-center justify-center" style="background: linear-gradient(to bottom,#f7e08a,#d49a24);">
                                Task
                            </button>
                        </div>

                        
                        <div class="flex items-stretch">
                            <div class="w-px h-12 bg-[#3a2a1a]/35"></div>
                        </div>

                        
                        <div class="flex flex-col items-start gap-0.5">
                            <span>25%</span>
                            <button class="h-8 min-w-[88px] rounded-[10px] bg-[#303030] px-4 text-[11px] font-semibold text-slate-100 flex items-center justify-center">
                                In review
                            </button>
                        </div>

                        
                        <div class="flex items-stretch">
                            <div class="w-px h-12 bg-[#3a2a1a]/25"></div>
                        </div>

                        
                        <div class="flex flex-col items-start gap-0.5">
                            <span>0%</span>
                            <button class="h-8 min-w-[64px] rounded-[10px] bg-[#c4c4c4] px-3 text-[11px] font-semibold text-[#3a2a1a] flex items-center justify-center">
                                Done
                            </button>
                        </div>
                    </div>
                </div>

                <div class="mt-4 rounded-[32px] bg-[#303030] text-slate-50 shadow-[0_26px_60px_rgba(10,10,20,0.45)] px-5 pt-5 pb-6">
                    <div class="flex items-center justify-between text-xs">
                        <span>Onboarding Task</span>
                        <span class="text-lg font-light tracking-wide">2/8</span>
                    </div>

                    <div class="mt-4 space-y-3 text-[11px]">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3 text-slate-400 line-through">
                                <div class="h-8 w-8 rounded-full bg-slate-700/70 flex items-center justify-center text-xs">💬</div>
                                <div>
                                    <div>Interview</div>
                                    <div class="text-[10px] text-slate-500">Sep 13, 08:30</div>
                                </div>
                            </div>
                            <span class="h-5 w-5 rounded-full bg-[#f4cf60] inline-flex items-center justify-center text-[10px] text-[#3a2a1a]">✓</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3 text-slate-400 line-through">
                                <div class="h-8 w-8 rounded-full bg-slate-700/70 flex items-center justify-center text-xs">⚡</div>
                                <div>
                                    <div>Team Meeting</div>
                                    <div class="text-[10px] text-slate-500">Sep 13, 10:30</div>
                                </div>
                            </div>
                            <span class="h-5 w-5 rounded-full bg-[#f4cf60] inline-flex items-center justify-center text-[10px] text-[#3a2a1a]">✓</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3 text-slate-100">
                                <div class="h-8 w-8 rounded-full bg-slate-100 text-slate-900 flex items-center justify-center text-xs">💭</div>
                                <div>
                                    <div>Project Update</div>
                                    <div class="text-[10px] text-slate-500">Sep 13, 13:00</div>
                                </div>
                            </div>
                            <span class="h-5 w-5 rounded-full border border-slate-600 inline-flex items-center justify-center text-[10px] text-slate-400"></span>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3 text-slate-100">
                                <div class="h-8 w-8 rounded-full bg-slate-100 text-slate-900 flex items-center justify-center text-xs">📝</div>
                                <div>
                                    <div>Discuss Q3 Goals</div>
                                    <div class="text-[10px] text-slate-500">Sep 13, 14:45</div>
                                </div>
                            </div>
                            <span class="h-5 w-5 rounded-full border border-slate-600 inline-flex items-center justify-center text-[10px] text-slate-400"></span>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3 text-slate-100">
                                <div class="h-8 w-8 rounded-full bg-slate-100 text-slate-900 flex items-center justify-center text-xs">📄</div>
                                <div>
                                    <div>HR Policy Review</div>
                                    <div class="text-[10px] text-slate-500">Sep 13, 16:30</div>
                                </div>
                            </div>
                            <span class="h-5 w-5 rounded-full border border-slate-600 inline-flex items-center justify-center text-[10px] text-slate-400"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('../themes/' . $activeTheme . '/' . $activeLayout, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\ERP System\Source\resources\views/project/dashboard.blade.php ENDPATH**/ ?>