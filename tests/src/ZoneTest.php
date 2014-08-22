<?php

namespace NoccyLabs\Thermal;

class ZoneTest extends \PhpUnit_Framework_TestCase
{
    public function setup()
    {
        Zone::setSysfsRoot( __DIR__."/../static" );
    }
    
    public function testEnumeratingZones()
    {
        $zones = Zone::getAllZones();
        $this->assertEquals(2, count($zones));
        $this->assertArrayHasKey("thermal_zone0", $zones);
        $this->assertArrayHasKey("thermal_zone1", $zones);
        $this->assertInstanceOf('NoccyLabs\Thermal\Zone', $zones["thermal_zone0"]);
        $this->assertInstanceOf('NoccyLabs\Thermal\Zone', $zones["thermal_zone1"]);
    }
    
    /**
     *
     * @expectedException InvalidArgumentException
     */
    public function testCreatingInvalidZone()
    {
        $zone2 = new Zone("thermal_zone2");
    }
    
    public function testReadingZoneTemperatures()
    {
        $zone0 = new Zone("thermal_zone0");
        $this->assertEquals("thermal_zone0", $zone0->getName());
        $this->assertEquals(48.0, $zone0->getTemp());
        $zone1 = new Zone("thermal_zone1");
        $this->assertEquals("thermal_zone1", $zone1->getName());
        $this->assertEquals(64.0, $zone1->getTemp());
    }
    
    public function testReadingZoneInformation()
    {
        $zones = Zone::getAllZones();
        foreach($zones as $zone) {
            $this->assertEquals("acpitz", $zone->getType());
            $this->assertEquals("enabled", $zone->getMode());
            $this->assertEquals("step_wise", $zone->getPolicy());
        }
    }
}

