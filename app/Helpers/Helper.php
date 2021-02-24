<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;
use Carbon\Carbon;

class Helper
{
    public static function shout($some_date)
    {
        try {
            return Carbon::createFromFormat('H:i:s', $some_date)->format('g:i A');
            // ->setTimezone('America/Los_Angeles');
        } catch (\Exception $th ) {
            return $th;
           }
       
    }
}