<div class="bg-white dark:bg-darkmode-600 rounded-lg shadow-sm border border-slate-200/60 dark:border-darkmode-400 mt-5 intro-y">
    <div class="flex items-center border-b border-slate-200/60 p-5 dark:border-darkmode-400">
        <h2 class="mr-auto text-base font-medium flex items-center">
            <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Palette','class' => 'w-5 h-5 mr-2 text-gray-500']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Palette','class' => 'w-5 h-5 mr-2 text-gray-500']); ?>
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
            Appearance & Theme
        </h2>
    </div>

    <form
        id="appearance-settings-form"
        action="<?php echo e(route('settings.appearance.update')); ?>"
        method="POST"
        class="p-5"
    >
        <?php echo csrf_field(); ?>

        <?php
            $palettes = config('theme.palettes', []);
            $activePalette = setting('theme_palette', config('theme.default_palette'));
        ?>

        <div class="grid grid-cols-12 gap-6">
            <!-- Dark Mode -->
            <div class="col-span-12 md:col-span-6">
                <div class="flex items-center mt-2">
                    <div>
                        <div class="font-medium">Dark Mode</div>
                        <div class="text-xs text-slate-500">Toggle dark mode for the application UI.</div>
                    </div>
                    <div class="ml-auto">
                        <input type="hidden" name="dark_mode" value="0">
                        <label class="inline-flex cursor-pointer items-center">
                            <input
                                type="checkbox"
                                name="dark_mode"
                                value="1"
                                id="appearance-dark-mode-toggle"
                                <?php echo e(setting('dark_mode', false) ? 'checked' : ''); ?>

                                class="sr-only peer"
                            />
                            <div class="relative w-11 h-6 rounded-full bg-slate-200 transition-colors duration-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/25 dark:bg-darkmode-600 peer-checked:bg-primary after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:h-5 after:w-5 after:rounded-full after:bg-white after:shadow after:transition-all after:duration-200 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full"></div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Animations -->
            <div class="col-span-12 md:col-span-6">
                <div class="flex items-center mt-2">
                    <div>
                        <div class="font-medium">Animations</div>
                        <div class="text-xs text-slate-500">Enable or disable UI animations.</div>
                    </div>
                    <div class="ml-auto">
                        <input type="hidden" name="animations_enabled" value="0">
                        <label class="inline-flex cursor-pointer items-center">
                            <input
                                type="checkbox"
                                name="animations_enabled"
                                value="1"
                                id="appearance-animations-toggle"
                                <?php echo e(setting('animations_enabled', true) ? 'checked' : ''); ?>

                                class="sr-only peer"
                            />
                            <div class="relative w-11 h-6 rounded-full bg-slate-200 transition-colors duration-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/25 dark:bg-darkmode-600 peer-checked:bg-primary after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:h-5 after:w-5 after:rounded-full after:bg-white after:shadow after:transition-all after:duration-200 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full"></div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Theme palettes -->
            <div class="col-span-12">
                <?php if (isset($component)) { $__componentOriginal0b5a207e31917d1ae3d42744188acbdf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-label.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>Accent Colors <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0b5a207e31917d1ae3d42744188acbdf)): ?>
<?php $attributes = $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf; ?>
<?php unset($__attributesOriginal0b5a207e31917d1ae3d42744188acbdf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0b5a207e31917d1ae3d42744188acbdf)): ?>
<?php $component = $__componentOriginal0b5a207e31917d1ae3d42744188acbdf; ?>
<?php unset($__componentOriginal0b5a207e31917d1ae3d42744188acbdf); ?>
<?php endif; ?>
                <p class="text-xs text-slate-500 mb-3">Choose a curated palette to keep the UI consistent.</p>
                <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                    <?php $__currentLoopData = $palettes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $palette): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $isActive = $activePalette === $key;
                            $gradient = "linear-gradient(120deg, {$palette['primary']} 0%, {$palette['secondary']} 50%, {$palette['accent']} 100%)";
                        ?>
                        <label
                            class="relative flex cursor-pointer flex-col rounded-2xl border border-slate-200/80 bg-slate-50 p-4 transition hover:border-primary/60 hover:shadow-lg dark:border-darkmode-500 dark:bg-darkmode-600"
                            data-palette-card
                        >
                            <input
                                type="radio"
                                name="theme_palette"
                                value="<?php echo e($key); ?>"
                                class="sr-only"
                                data-palette-input
                                <?php echo e($isActive ? 'checked' : ''); ?>

                            >
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-semibold text-slate-700 dark:text-slate-100"><?php echo e($palette['label']); ?></p>
                                    <p class="text-xs text-slate-500 dark:text-slate-400"><?php echo e($palette['description']); ?></p>
                                </div>
                                <div class="rounded-xl border border-white/70 shadow-inner" style="background-image: <?php echo e($gradient); ?>; width: 72px; height: 32px"></div>
                            </div>
                            <div class="mt-4 flex gap-2">
                                <span class="flex-1 rounded-lg border border-white/60 bg-white/80 py-1 text-center text-[11px] font-semibold text-slate-600 dark:text-slate-200" style="color: <?php echo e($palette['primary']); ?>">
                                    <?php echo e($palette['primary']); ?>

                                </span>
                                <span class="flex-1 rounded-lg border border-white/60 bg-white/80 py-1 text-center text-[11px] font-semibold text-slate-600 dark:text-slate-200" style="color: <?php echo e($palette['secondary']); ?>">
                                    <?php echo e($palette['secondary']); ?>

                                </span>
                                <span class="flex-1 rounded-lg border border-white/60 bg-white/80 py-1 text-center text-[11px] font-semibold text-slate-600 dark:text-slate-200" style="color: <?php echo e($palette['accent']); ?>">
                                    <?php echo e($palette['accent']); ?>

                                </span>
                            </div>
                            <span class="pointer-events-none absolute right-4 top-4 rounded-full border border-primary/20 bg-white/80 p-1 text-primary opacity-0 scale-90 transition" data-palette-check>
                                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Check','class' => 'h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Check','class' => 'h-4 w-4']); ?>
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
                            </span>
                        </label>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <!-- Font Size -->
            <div class="col-span-12 md:col-span-6">
                <?php if (isset($component)) { $__componentOriginal0b5a207e31917d1ae3d42744188acbdf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-label.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>Font Size <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0b5a207e31917d1ae3d42744188acbdf)): ?>
<?php $attributes = $__attributesOriginal0b5a207e31917d1ae3d42744188acbdf; ?>
<?php unset($__attributesOriginal0b5a207e31917d1ae3d42744188acbdf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0b5a207e31917d1ae3d42744188acbdf)): ?>
<?php $component = $__componentOriginal0b5a207e31917d1ae3d42744188acbdf; ?>
<?php unset($__componentOriginal0b5a207e31917d1ae3d42744188acbdf); ?>
<?php endif; ?>
                <?php $fontSize = setting('font_size', 'medium'); ?>
                <?php if (isset($component)) { $__componentOriginal1c0beb3cd2271cd34645d22f15db5e3a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1c0beb3cd2271cd34645d22f15db5e3a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.form-select.index','data' => ['name' => 'font_size','class' => 'w-full mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.form-select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'font_size','class' => 'w-full mt-2']); ?> 
                    <option value="small" <?php echo e($fontSize === 'small' ? 'selected' : ''); ?>>Small</option>
                    <option value="medium" <?php echo e($fontSize === 'medium' ? 'selected' : ''); ?>>Medium</option>
                    <option value="large" <?php echo e($fontSize === 'large' ? 'selected' : ''); ?>>Large</option>
                    <option value="extra-large" <?php echo e($fontSize === 'extra-large' ? 'selected' : ''); ?>>Extra Large</option>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1c0beb3cd2271cd34645d22f15db5e3a)): ?>
<?php $attributes = $__attributesOriginal1c0beb3cd2271cd34645d22f15db5e3a; ?>
<?php unset($__attributesOriginal1c0beb3cd2271cd34645d22f15db5e3a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1c0beb3cd2271cd34645d22f15db5e3a)): ?>
<?php $component = $__componentOriginal1c0beb3cd2271cd34645d22f15db5e3a; ?>
<?php unset($__componentOriginal1c0beb3cd2271cd34645d22f15db5e3a); ?>
<?php endif; ?>
            </div>
        </div>

        <div class="mt-5 flex items-center justify-between">
            <button type="submit" class="btn-royal btn-royal--gold btn-royal--sm w-40">
                <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'save','class' => 'w-4 h-4 mr-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'save','class' => 'w-4 h-4 mr-2']); ?>
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
                Save Appearance
            </button>

            <button type="button" class="btn-royal btn-royal--outline btn-royal--sm" onclick="event.preventDefault(); if (confirm('Reset theme colors to default values?')) window.resetThemeSettings && window.resetThemeSettings();">
                Reset Theme
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const paletteInputs = document.querySelectorAll('[data-palette-input]');
        const paletteCards = document.querySelectorAll('[data-palette-card]');

        function updatePaletteState() {
            paletteCards.forEach(card => {
                const input = card.querySelector('[data-palette-input]');
                const check = card.querySelector('[data-palette-check]');
                const isActive = input?.checked;

                card.classList.toggle('ring-2', !!isActive);
                card.classList.toggle('ring-primary/60', !!isActive);
                card.classList.toggle('bg-slate-100/80', !!isActive);
                card.classList.toggle('dark:bg-darkmode-500/80', !!isActive);
                if (check) {
                    check.classList.toggle('opacity-100', !!isActive);
                    check.classList.toggle('opacity-0', !isActive);
                    check.classList.toggle('scale-100', !!isActive);
                    check.classList.toggle('scale-90', !isActive);
                }
            });
        }

        paletteInputs.forEach(input => {
            input.addEventListener('change', () => {
                paletteInputs.forEach(other => {
                    if (other !== input) {
                        other.checked = false;
                    }
                });
                input.checked = true;
                updatePaletteState();
            });
        });

        updatePaletteState();
    });
</script>
<?php /**PATH E:\ERP System\Source\resources\views/settings/partials/appearance.blade.php ENDPATH**/ ?>