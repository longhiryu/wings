<?php

    function myCurrency($number)
    {
        if (is_numeric($number)) {
            return number_format($number, 0, ',', '.');
        }

        return 'Please pass a number to this helper';
    }

    function formatNumber($number)
    {
        if (is_numeric($number)) {
            return number_format($number, 0, ',', '.');
        }

        return 'Please pass a number to this helper';
    }

    function my_format_number($number)
    {
        if (is_numeric($number)) {
            return number_format($number, 0, ',', '.');
        }

        return 'Please pass a number to this helper';
    }

    function size_as_kb($yoursize) {
        if($yoursize < 1024) {
          return "{$yoursize} bytes";
        } elseif($yoursize < 1048576) {
          $size_kb = round($yoursize/1024);
          return "{$size_kb} KB";
        } else {
          $size_mb = round($yoursize/1048576, 1);
          return "{$size_mb} MB";
        }
      }
