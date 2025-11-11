<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class ThemeController extends Controller
{
    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function switch(Request $request): RedirectResponse
    {
        // Always set theme to 'enigma' regardless of the request
        session([
            'activeTheme' => 'enigma'
        ]);

        return redirect("/");
    }
}
