<?php

namespace Xdm\Ipnet;

use Illuminate\Support\Facades\Config;
use Xdm\Ipnet\IpxCache;

class IpxDataUpdate
{
    private static $download_url = 'http://user.ipip.net/download.php';
    private static $latest_file_tag = 'ipx_latest_datafile';
    private static $obj = null;

    private function __construct(){

    }

    public static function getInstance(){
        if(self::$obj === null){
            self::$obj = new IpxDataUpdate();
        }
        return self::$obj;
    }

    /**
     * Update Ipx data file
     */
    public function make(){
        $token = Config::get("ipnet.token");
        $url = self::$download_url . '?token=' . $token . '&type=datx';
        $this->download($url);
    }

    /**
     * Download the latest data file
     *
     * @param $url
     */
    public function download($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $res = curl_exec($ch);
        curl_close($ch);

        $file_name = 'ipx_'.date('Ymd', time()).'.datx';
        file_put_contents(__DIR__ . "/Data/" . $file_name, $res);
        IpxCache::put(self::$latest_file_tag, $file_name, 1440);
        $data_files_list = $this->getDataFilesList();
        $this->deleteExpire($data_files_list);
    }

    /**
     * Delete expire data file
     *
     * @param $files_list
     */
    public function deleteExpire($files_list){
        $data_dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'Data';
        foreach($files_list as $key => $file){
            if($key >= Config::get("ipnet.expire_num")){
                unlink($data_dir. DIRECTORY_SEPARATOR . $file['name']);
            }
        }
    }

    /**
     * Get the latest data file name
     *
     * @return mixed
     */
    public function getLatestFile($type){
        if(IpxCache::get(self::$latest_file_tag)){
            return IpxCache::get(self::$latest_file_tag);
        }

        $files_list = $this->getDataFilesList();
        $latest_file = '';
        foreach($files_list as $file){
            if($file['type'] == $type){
                $latest_file = $file['name'];
                break;
            }
        }
        IpxCache::put(self::$latest_file_tag, $latest_file, 1440);
        return $latest_file;
    }

    /**
     * Get data files list
     *
     * @return array
     */
    public function getDataFilesList(){
        $data_dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'Data';
        $files = scandir($data_dir);

        $files_list = array();
        $index = 0;
        foreach ($files as $file) {
            if($file != '.' && $file != '..'){
                $files_list[$index]['name'] = $file;
                $files_list[$index]['update_time'] = filemtime($data_dir . DIRECTORY_SEPARATOR . $file);
                $files_list[$index]['type'] = $this->getFileType($file);
                $index++;
            }
        }

        $update_times = array();
        foreach($files_list as $data){
            $update_times[] = $data['update_time'];
        }
        array_multisort($update_times, SORT_DESC, $files_list);
        return $files_list;
    }

    /**
     * Get file type
     *
     * @param $file
     */
    public function getFileType($file){
        $file_array = explode('.', $file);
        return $file_array[count($file_array) - 1];
    }
}