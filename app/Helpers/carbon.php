<?php

use Illuminate\Support\Carbon;

if (!function_exists('parse')) {
    function parse($date)
    {
        return Carbon::parse($date);
    }
}

if (!function_exists('now')) {
    function now()
    {
        return Carbon::now();
    }
}

if (!function_exists('readAsHuman')) {
    function readAsHuman($date, $format, $toFormat = null)
    {
        Carbon::setLocale('id_ID');
        if (!$toFormat) {
            $toFormat = $format;
        }

        return Carbon::createFromFormat($format, $date)->translatedFormat($toFormat);
    }
}

if (!function_exists('formatDate')) {
    function formatDate($date, $format = 'd F Y, H:i', $locale = 'id_ID')
    {
        if ($locale != 'id_ID') {
            Carbon::setLocale($locale);
        }

        return parse($date)->translatedFormat($format);
    }
}
