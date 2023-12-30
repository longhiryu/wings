<?php

    function formatDateTime($datetime, $type = 'date')
    {
        Carbon\Carbon::setLocale(config('app.locale'));

        if ($type == 'date') {
            return Carbon\Carbon::parse($datetime)->translatedFormat('d-m-Y');
        }
        return Carbon\Carbon::parse($datetime)->translatedFormat('d-m-Y H:i:s');
    }
