---
title: 中国大陆重点城市空气质量历史数据库
---

![Screenshots](http://files.gracecode.com/2014_03_12/1394590858@640.png)

数据库基于 [中华人民共和国环境保护部信息中心](http://datacenter.mep.gov.cn/) 等公共数据来源抓取并汇总而成，提供给网友作为当地空气质量的历史数据参考。

**目前数据库包含 ``3231`` 个地区的总计 ``376454`` 条数据，时间跨度为 ``2000-06-05`` 至 ``2013-12-30`` 日。** 

注：后续数据抓取因资源方面以及政策等方面的限制，不再抓取感谢理解。


### 下载连接

```
$ md5sum  aqi.sqlite.gz 
ed7b0cc13c379fe6e9546511632e4842  aqi.sqlite.gz
```

* [本地下载](https://www.dropbox.com/s/4os66iar0dn9nzo/aqi.sqlite.gz)
* [分流连接](http://pan.baidu.com/s/1sjycHFB)


如果还是无法下载，请联系我 ：）


### 常见问题

#### 版权问题？

本项目抓取部分的代码使用 [LGPL 协议](https://github.com/feelinglucky/AQI/blob/master/LICENSE) ，可以自由使用。

数据来源主要为 [中华人民共和国环境保护部信息中心](http://datacenter.mep.gov.cn/) ，因此以此机构制定的明文细则为准。本人个人不承担任何因此造成的直接、间接后果。


#### 数据表结构说明在哪里？

在项目中已经说明了，参见 [https://github.com/feelinglucky/AQI](https://github.com/feelinglucky/AQI)。


#### 时间戳格式如何转换为可读时间？

使用 sqlite 的 ``datetime`` 函数即可，例如 

```
select datetime(recordDate, 'unixepoch', 'localtime') from aqi limit 1; 
```

详情参见 [https://sqlite.org/lang_datefunc.html](https://sqlite.org/lang_datefunc.html) 。



### 源代码

本项目是开源项目，您可以自由下载和查看源代码，并用于自定义规则的抓取。项目地址为 [https://github.com/feelinglucky/AQI](https://github.com/feelinglucky/AQI)，建议在运行此项目前请仔细阅读 ``README`` 文件。



