<?php
/*
 * CustomDesignHelper
 * Helper to be used for generating printable value
 */
namespace App\Library;
use Faker\Provider\DateTime;
use File;
use function GuzzleHttp\Psr7\str;

class WorkingTImeHeper
{
    public static function openTill($shop){
        $today = strtolower(date('l'));
        $tomorrow = strtolower(date('l', strtotime($today.' +1 day')));
        $now = strtotime('now');
        $wh = json_decode($shop->working_hours, true);
        $shop->isOpen = false;

        if(isset($wh[$today])){
            if($now > strtotime($wh[$today]['hours_from']) && $now < strtotime($wh[$today]['hours_to'])){
                $shop->isOpen = true;
                if($wh[$today]['hours_to'] === '23:59'){

                    if($wh[$tomorrow]['hours_from'] === '00:00'){
                        if($wh[$tomorrow]['hours_to'] === '23:59'){
                            $shop->openTill = 'all night';
                            return;
                        }else{
                            $shop->openTill = $wh[$tomorrow]['hours_to'];
                            return;
                        }
                    }else{
                        $shop->openTill = $wh[$today]['hours_to'];
                        return;
                    }
                }
                $shop->openTill = $wh[$today]['hours_to'];
            }
        }
    }
}
