<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class LocaleController extends Controller
{
    public function __invoke(Request $request, string $locale)
    {
        if (! in_array($locale, ['en', 'ar'], true)) {
            abort(404);
        }
        session(['locale' => $locale]);

        return Redirect::back();
    }
}
