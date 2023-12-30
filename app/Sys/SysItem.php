<?php

namespace App\Sys;

use File;

class SysItem
{
    public function checkImage($url)
        {
            return File::exists($url) ? $url : '/images/no-image.png';
        }
}