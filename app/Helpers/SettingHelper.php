<?php

use App\Models\Setting;

function getSetting($key, $settings)
{
    $data = $settings->filter(function($item) use($key){
        return $item->name == $key;
    })->first();

    return optional($data)->val;
}
