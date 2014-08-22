<?php

require_once __DIR__."/../vendor/autoload.php";

use NoccyLabs\Thermal;

define("BUFFER_SIZE", 5);

$zones = Thermal\Zone::getAllZones();

$buff = array();
$vals = null; $c=0;
while(true) {
    $vals = array();
    foreach ($zones as $zone) {
        $vals[] = sprintf("%.1f",$zone->getTemp());
    }
    $buff[] = $vals;
    $last = $vals;

    if (count($buff)>BUFFER_SIZE) { array_shift($buff); }
    $buffs = count($buff);
    foreach($vals as $i=>$vcur) {
        $avg = array_sum(array_column($buff, $i))/$buffs;
        $vals[$i] = sprintf("%.1f", $avg);
    }
    $vals = array_merge($last, $vals);
    array_unshift($vals, $c++);
    fputcsv(STDOUT, $vals, ';');
    sleep(5);
}


