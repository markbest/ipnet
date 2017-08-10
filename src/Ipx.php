<?php

namespace Xdm\Ipnet;

use Xdm\Ipnet\IpxCache;
use Xdm\Ipnet\Ipdat;
use Xdm\Ipnet\Ipdatx;

class Ipx
{
    /**
     * @param $ip
     * @param string $type
     * @return mixed|null|string
     */
    public static function find($ip, $type = 'datx')
    {
        $cache_tag = 'Ipx';
        $ip_cache = IpxCache::get($cache_tag, $ip);
        if($ip_cache){
            return $ip_cache;
        }else{
            if($type == 'datx'){
                $result = Ipdatx::find($ip);
            }else{
                $result = Ipdat::find($ip);
            }

            if(count($result)){
                IpxCache::forever($cache_tag, $ip, $result);
            }
            return $result;
        }
    }
}