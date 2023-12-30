<?php

namespace App\Sys;

use DateTime;
use Carbon\Carbon;
use App\Models\CodeSerie;

class SysCore
{
    public static function greeting()
    {
        $currentTime = Carbon::now();
        $currentHour = $currentTime->hour;

        if ($currentHour >= 4 && $currentHour < 12) {
            return [
                'greeting' => __('text.greeting_morning'),
                'text' => __('text.greeting_morning_text'),
            ];
        } elseif ($currentHour >= 12 && $currentHour < 14) {
            return [
                'greeting' => __('text.greeting_noon'),
                'text' => __('text.greeting_noon_text'),
            ];
        } elseif ($currentHour >= 14 && $currentHour < 18) {
            return [
                'greeting' => __('text.greeting_afternoon'),
                'text' => __('text.greeting_afternoon_text'),
            ];
        }

        return [
            'greeting' => __('text.greeting_night'),
            'text' => __('text.greeting_night_text'),
        ];

        return [
            'greeting' => __('text.greeting_noon'),
            'text' => __('text.greeting_noon_text'),
        ];
    }

    public function convetSlugToTitle(string $slug)
    {
        $originalString = $slug;
        $words = explode('-', $originalString);
        $capitalizedWords = array_map('ucfirst', $words);
        $resultString = implode(' ', $capitalizedWords);

        return $resultString;
    }

    public function textLimit($str, int $limit)
    {
        if ($str === null) {
            return null;
        }
        $count = strlen($str);
        $dots = null;
        if ($count > $limit) {
            $dots = '...';
        }
        $str_s = null;
        if (stripos($str, ' ')) {
            $ex_str = explode(' ', $str);
            if (count($ex_str) > $limit) {
                for ($i = 0; $i < $limit; $i++) {
                    $str_s .= $ex_str[$i] . ' ';
                }

                return $str_s . $dots;
            }

            return $str;
        }

        return $str;
    }

    public function getDomain()
    {
        return parse_url(request()->root())['host'];
    }

    public static function strRandom($length = 17)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    public function numberClean($number)
    {
        $number = str_replace(',', '', $number);
        $number = str_replace('.', '', $number);

        return (int) $number;
    }

    public function floatClean($number)
    {
        $number = str_replace(',', '', $number);

        return (float) $number;
    }

    public function timeToStr($datetime, $full = false)
    {
        $now = new DateTime();
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = [
            'y' => 'năm',
            'm' => 'tháng',
            'w' => 'tuần',
            'd' => 'ngày',
            'h' => 'giờ',
            'i' => 'phút',
            's' => 'giây',
        ];
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v; // . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (! $full) {
            $string = array_slice($string, 0, 1);
        }

        return $string ? implode(', ', $string) . ' trước' : 'vừa cập nhật'; //' ago' : 'just now';
    }

    public function arraySortByColumn($arr, $col, $dir = SORT_ASC)
    {
        $sort_col = [];
        foreach ($arr as $key => $row) {
            $sort_col[$key] = $row[$col];
        }

        array_multisort($sort_col, $dir, $arr);

        return $arr;
    }

    public function moneyFormat()
    {
    }

    public function getEloquentSqlWithBindings($query)
    {
        return vsprintf(str_replace('?', '%s', $query->toSql()), collect($query->getBindings())->map(function ($binding) {
            $binding = addslashes($binding);

            return is_numeric($binding) ? $binding : "'{$binding}'";
        })->toArray());
    }

    public function numToWord($number)
    {
        $hyphen = ' ';
        $conjunction = '  ';
        $separator = ' ';
        $negative = 'âm ';
        $decimal = ' phẩy ';
        $dictionary = [
            0 => 'không',
            1 => 'một',
            2 => 'hai',
            3 => 'ba',
            4 => 'bốn',
            5 => 'năm',
            6 => 'sáu',
            7 => 'bảy',
            8 => 'tám',
            9 => 'chín',
            10 => 'mười',
            11 => 'mười một',
            12 => 'mười hai',
            13 => 'mười ba',
            14 => 'mười bốn',
            15 => 'mười năm',
            16 => 'mười sáu',
            17 => 'mười bảy',
            18 => 'mười tám',
            19 => 'mười chín',
            20 => 'hai mươi',
            30 => 'ba mươi',
            40 => 'bốn mươi',
            50 => 'năm mươi',
            60 => 'sáu mươi',
            70 => 'bảy mươi',
            80 => 'tám mươi',
            90 => 'chín mươi',
            100 => 'trăm',
            1000 => 'nghìn',
            1000000 => 'triệu',
            1000000000 => 'tỷ',
            1000000000000 => 'nghìn tỷ',
            1000000000000000 => 'nghìn triệu triệu',
            1000000000000000000 => 'tỷ tỷ',
        ];
        if (! is_numeric($number)) {
            return false;
        }
        if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
            // overflow
            trigger_error(
                'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
                E_USER_WARNING
            );

            return false;
        }
        if ($number < 0) {
            return $negative . $this->NumToWord(abs($number));
        }
        $string = $fraction = null;
        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }
        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];

                break;
            case $number < 100:
                $tens = ((int) ($number / 10)) * 10;
                $units = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string .= $hyphen . $dictionary[$units];
                }

                break;
            case $number < 1000:
                $hundreds = $number / 100;
                $remainder = $number % 100;
                $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                if ($remainder) {
                    $string .= $conjunction . $this->NumToWord($remainder);
                }

                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int) ($number / $baseUnit);
                $remainder = $number % $baseUnit;
                $string = $this->NumToWord($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                if ($remainder) {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                    $string .= $this->NumToWord($remainder);
                }

                break;
        }
        if (null !== $fraction && is_numeric($fraction)) {
            $string .= $decimal;
            $words = [];
            foreach (str_split((string) $fraction) as $number) {
                $words[] = $dictionary[$number];
            }
            $string .= implode(' ', $words);
        }

        return $string;
    }

    /**
     * Method createFileName
     *
     * @param string $filename [explicite description]
     *
     * @return string
     */
    public function createFileName(string $filename)
    {
        $kyTuDacBiet = ['~', '`', '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '_', '+', '-', '=', '[', ']', '{', '}', ';', ':', "'", '"', '<', '>', ',', '/', '?', '\\', '|'];

        return str_replace($kyTuDacBiet, '', $filename);
    }
}
