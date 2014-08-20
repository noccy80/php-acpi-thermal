ACPI Thermal
============

Read the temperature readings from the ACPI sysfs

## Installation

        $ composer require noccylabs/acpi-thermal:0.1.*
        

## Usage

You can get a collection of all the available thermal zones using the static
`getAllZones()` method:

        use NoccyLabs\Thermal;

        $zones = Thermal\Zone::getAllZones();
        foreach ($zones as $zone) {
            printf("%s = %.1fºC\n",
                $zone->getName(),
                $zone->getTemp()
            );
        }

You can also create a zone directly and start reading from it (assuming it exists):

        $zone = new Thermal\Zone("thermal_zone0");        
        echo $zone->getTemp();

