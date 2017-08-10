## 使用方法
- 1、composer require "Xdm/ipnet"
- 2、在config/app中添加Xdm\Ipnet\IpnetServiceProvider::class
- 3、执行命令php artisan vendor:publish --provider="Xdm\Ipnet\IpnetServiceProvider", 生成配置文件ipnet.php
- 4、执行命令php artisan ipnet:update下载解析IP需要的数据源文件
- 5、调用方法：
```
use Xdm\Ipnet\Ipx;
use Xdm\Ipnet\IpxLocation;
Ipx::find($ip);
IpxLocation::find($ip);
```  

## 特色功能
- 扩展包提供两种数据源文件的解析：dat和datx，程序会自动识别最新的数据源文件格式来进行解析
- 配置文件中可以设置保存数据源文件的版本数量
- 解析IP的结果使用cache缓存，查询IP会优先从缓存中获取
- 两种解析IP的方式可以自选