<?php

use App\Http\Controllers\ContactController;
use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Route;

foreach (config('site.locales') as $locale) {
    $prefix = $locale === config('site.default_locale') ? '' : $locale;

    Route::prefix($prefix)
        ->name("{$locale}.")
        ->middleware(SetLocale::class.":{$locale}")
        ->group(function (): void {
            Route::view('/', 'pages.home')->name('home');

            Route::post('/contact', [ContactController::class, 'store'])
                ->middleware('throttle:5,1')
                ->name('contact.store');
        });
}
