<?php

namespace App\Support;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class Localized
{
    /**
     * Generate the URL of a named route in the current locale.
     *
     * @param  array<string, mixed>  $parameters
     */
    public static function route(string $name, array $parameters = []): string
    {
        return route(app()->getLocale().'.'.$name, $parameters);
    }

    /**
     * Generate the URL of the current page in another locale.
     */
    public static function switchTo(string $locale): string
    {
        $currentRoute = request()->route();
        $currentName = $currentRoute?->getName();

        if ($currentName === null || ! Str::contains($currentName, '.')) {
            return route($locale.'.home');
        }

        $targetName = $locale.'.'.Str::after($currentName, '.');

        if (! Route::has($targetName) || ! in_array('GET', $currentRoute->methods(), true)) {
            return route($locale.'.home');
        }

        // Keep URI parameters only: Route::view() also stores "view" and "status" as defaults.
        $uriParameters = array_intersect_key($currentRoute->parameters(), array_flip($currentRoute->parameterNames()));

        return route($targetName, $uriParameters);
    }
}
