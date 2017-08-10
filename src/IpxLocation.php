<?php

namespace Xdm\Ipnet;

use Xdm\Ipnet\IpLocation;

class IpxLocation
{
    public static function find($ip)
    {
        $cache_tag = 'IpxLocation';
        $ip_cache = IpxCache::get($cache_tag, $ip);
        if($ip_cache){
            return $ip_cache;
        }else{
            $ip_location = new IpLocation(__DIR__ . DIRECTORY_SEPARATOR .'Data' . DIRECTORY_SEPARATOR . 'ip.bin', IpLocation::FILE_IO);
            $result = $ip_location->lookup($ip, IpLocation::ALL);
            if(count($result)){
                IpxCache::forever($cache_tag, $ip, $result);
            }
        }
    }
}