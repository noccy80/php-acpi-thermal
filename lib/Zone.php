<?php

/*
 * Copyright (C) 2014, NoccyLabs
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>
 */

namespace NoccyLabs\Thermal;

/**
 * Access a ACPI thermal zone and its information
 *
 * @author Christopher Vagnetoft <cvagnetoft@gmail.com>
 */
class Zone
{
    protected $zone_id;

    protected $zone_path;

    protected static $sysfs_root = "/sys/class/thermal";

    public static function getAllZones()
    {
        $sysfs_root = self::$sysfs_root;
        $zones = glob("{$sysfs_root}/thermal_zone*");
        $ret = array();
        foreach($zones as $zone) {
            $zone_id = basename($zone);
            $ret[$zone_id] = new Zone($zone_id);
        }
        return $ret;
    }
    
    public function __construct($zone_id)
    {
        $sysfs_root = self::$sysfs_root;
        $this->zone_id   = $zone_id;
        $this->zone_path = "{$sysfs_root}/{$zone_id}";
        if (!is_dir($this->zone_path)) {
            $zones = join(", ", 
                array_map("basename", 
                    glob("{$sysfs_root}/thermal_zone*")));
            throw new \InvalidArgumentException("No such thermal zone {$zone_id}; Available are {$zones}");
        }
    }
    
    public function getName()
    {
        return $this->zone_id;
    }
    
    public function getTemp()
    {
        return floatval(file_get_contents("{$this->zone_path}/temp")) / 1000;
    }
    
    public function getType()
    {
        return trim(file_get_contents("{$this->zone_path}/type"));
    }

    public function getMode()
    {
        return trim(file_get_contents("{$this->zone_path}/mode"));
    }

    public function getPolicy()
    {
        return trim(file_get_contents("{$this->zone_path}/policy"));
    }

}

