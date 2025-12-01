<?php

namespace App\View\Composers;

use Illuminate\View\View;

class ThemeComposer
{
    /**
     * Bind menu to the view.
     */
    public function compose(View $view): void
    {
        if (!is_null(request()->route())) {
            $activeTheme = $this->activeTheme($view);
            $activeLayout = $this->activeLayout($view);
            $view->with('activeTheme', $activeTheme);
            $view->with('activeLayout', $activeLayout);
        }
    }

    /**
     * Selected theme.
     */
    public function activeTheme($view): string
    {
        if (isset($view->activeTheme)) {
            return $view->activeTheme;
        } else if (request()->has('active-theme')) {
            return request()->query('active-theme');
        }

        return session()->has('activeTheme') ? session('activeTheme') : "smart-erp";
    }

    /**
     * Selected layout.
     */
    public function activeLayout($view): string
    {
        if (isset($view->activeLayout)) {
            return $view->activeLayout;
        } else if (request()->has('active-layout')) {
            return request()->query('active-layout');
        }

        return session()->has('activeLayout') ? session('activeLayout') : "side-menu";
    }
}
