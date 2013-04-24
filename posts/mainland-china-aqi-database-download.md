---
title: 中国大陆重点城市空气质量（AQI）历史数据库
date: 2013-03-26
layout: post
categories:
    - 软件
---

![空气污染](http://files.gracecode.com/2013_03_26/1364268764.jpg)

我们生存的环境是越来越糟糕，很多不为人知的专业名词如
[PM2.5](http://zh.wikipedia.org/wiki/%E6%87%B8%E6%B5%AE%E7%B2%92%E5%AD%90) 、[三聚氰胺](http://zh.wikipedia.org/zh/%E4%B8%89%E8%81%9A%E6%B0%B0%E8%83%BA)  等都能让我们耳熟能详，估计再过几年我们这些老百姓都能变成化学方面的专家。

作为「数据采集爱好者」针对近十年国内空气质量的变化趋势非常感兴趣，刚好我们的 中华人民共和国环境保护部信息中心 提供了这样的数据，所以将他们站点的数据抓取了下来并整理成 SQLite 数据库，方便给大家用作数据分析使用。

![宁波历年空气质量曲线展示](http://files.gracecode.com/2013_03_26/1364269612@640.png)

例如，[我简单做了个表用于展示宁波地区 2001 - 2013 的空气质量曲线](http://graceco.de/aqi/)。

如果您要问我这些数据可靠吗？我只能告诉你这是从   [中华人民共和国环境保护部信息中心](http://datacenter.mep.gov.cn/)  官方抓取获得的数据，至于数据本身的真实性全凭您个人主观判断吧。目前采集脚本还继续在工作，所以不定期我还是会打包分享最新的数据包（但频率不会那么高）。

有关数据库表库字段方面的说明可以参考[项目的说明文档](https://github.com/feelinglucky/AQI)，这个项目所有的抓取脚本、说明文档都是开源的，[并放到了 github 上](https://github.com/feelinglucky/AQI)。

大家如果有其他更好的数据源，可以很方便的扩展这个脚本。欢迎大家能够提供更靠谱的数据源，将这个数据库中的数据完善起来。

如果需要在线查询接口的，可以考虑使用 [http://pm25.in/](http://pm25.in/) 服务，个人觉得很靠谱。

最后，[提供SQLite 数据库打包（bzip 格式）下载](https://code.google.com/p/gracecode/downloads/detail?name=aqi-20130326.sqlite.bz2)。PS，[题图出处在这里](http://www.chinafile.com/taxi-drivers-china-have-highest-pm25-air-pollutant-exposure)，其实图片没有看起来那么美…

`-- EOF --`
