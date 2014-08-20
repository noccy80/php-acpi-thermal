<?php

require_once __DIR__."/../vendor/autoload.php";

use NoccyLabs\Thermal;

$zones = Thermal\Zone::getAllZones();
foreach ($zones as $zone) {
    printf("%s = %.1fºC\n",
        $zone->getName(),
        $zone->getTemp()
    );
}


