<?php

namespace Xdm\Ipnet;

use Illuminate\Support\Facades\Cache;

class IpxCache
{
    /**
     * Get ip data from cache
     *
     * @param $ip
     * @return null
     */
    public static function get($cache_tag, $ip = ''){
        if($ip){
            $ip_cache_tag = $cache_tag.':'.$ip;
            if(Cache::has($ip_cache_tag)){
                return Cache::get($ip_cache_tag);
            }
        }else{
            if(Cache::has($cache_tag)){
                return Cache::get($cache_tag);
            }
        }
        return null;
    }

    /**
     * Forever save ip data in cache
     *
     * @param $ip
     * @param $content
     */
    public static function forever($cache_tag, $ip, $content){
        $ip_cache_tag = $cache_tag.':'.$ip;
        Cache::forever($ip_cache_tag, $content);
    }

    /**
     * Put data in cache
     *
     * @param $ip
     * @param $content
     */
    public static function put($tag, $content, $minutes){
        Cache::put($tag, $content, $minutes);
    }
}