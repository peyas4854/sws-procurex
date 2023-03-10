<?php

namespace App\Helpers;

use App\Services\SettingService;
use Carbon\Carbon;

use function PHPUnit\Framework\isNull;

class Parser
{
    public function __construct()
    {

    }

    public static function parseAmount($value)
    {
        $negative = false;

        if($value < 0){
            $negative = true;
        }

        // converting a number from negative to positive
        $number = abs($value);

        $d = 2;

        $n = number_format($number, $d, '.', '');
        $n = strrev($n);

        if ($d) {
            $d++;
        }
        $d += 3;

        if (strlen($n) > $d) {
            $n = substr($n, 0, $d) . ',' . implode(',', str_split(substr($n, $d), 2));
        }

        $formattedAmount = strrev($n);

        return $negative === true ? "({$formattedAmount})" : $formattedAmount;

    }

    public static function parseDate($date, $format=null)
    {
        $settingService = new SettingService();

        if(is_null($format) === true){
            $format = $settingService->get("date_format", "Y-m-d");
        }

        return (string)Carbon::parse($date)->format($format);
    }

    public static function parseDateTime($date, $format=null){
        $settingService = new SettingService();
        if(is_null($format) === true){
            $format = $settingService->get("date_format", "Y-m-d h:i");
        }
        return Carbon::parse($date)->format($format .' h:i');
    }

    public static function now($format = null)
    {
        if (is_null($format) === true) {
            $format = session()->get("settings.date_format", "Y-m-d");
        }

        return (string) Carbon::now()->format($format);
    }

    public static function parseDateForPrint($date, $format=null)
    {
        // dd($date);
        $settingService = new SettingService();

        if(is_null($format) === true){
            $format = $settingService->get("date_format", "Y-m-d");
        }
        if($date == null || empty($date)){
            return '';
        }
        return (string)Carbon::parse($date)->format($format);
    }

}
