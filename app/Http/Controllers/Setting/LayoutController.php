<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class LayoutController extends Controller
{
    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function switch(Request $request): RedirectResponse
    {
        session([
            'activeLayout' => $request->activeLayout
        ]);

        return redirect("/");
    }
}
