---
title: '升级和改造 NAS 小记'
date: '2014-11-03'
layout: post
categories:
    - 奇技淫巧
    - 我的生活
---

自从多年前开始使用 NAS 存储和备份数据，就慢慢得养成了习惯越来越离不开它了。我使用的是[群晖低端的 212J](http://www.techpowerup.com/reviews/Synology/DS212j/)，由于仅仅是备份数据没有离线下载等需求，使用至今都没有出现过性能方面的顾虑。

这次考虑折腾 NAS 是从一开始升级硬盘说起。

## 选择硬盘

因为预算的问题，一直没有购买新的硬盘，使用的是原先移动硬盘拆下来的两块 320g 笔记本硬盘。

时光推进， 320g 的容量越来越明显感觉到捉襟见肘，加上原有的硬盘使用时间也比较长（从 09 年至今），因此更换硬盘的想法就提上了心头。

![http://files.gracecode.com/2014_11_03/1415001492.jpg](http://files.gracecode.com/2014_11_03/1415001492.jpg)

![http://files.gracecode.com/2014_11_03/1415001505.jpg](http://files.gracecode.com/2014_11_03/1415001505.jpg)

根据目前的行情，还是考虑购买了两个不同品牌的监控硬盘，分别是 希捷（Seagate）的 SV35 系列 和 西数（WD） 的 AV-GP 系列，容量都是 2T。

选择不同个品牌，是因为考虑同个品牌可能会同一个批次出现一样的问题。同时，不选择西数的红盘是因为 AV-GP 系列性价比稍微更高些而已（虽然只有 20 大洋）。

![http://files.gracecode.com/2014_11_03/1415001468.png](http://files.gracecode.com/2014_11_03/1415001468.png)

后记：新的硬盘安装进去以后，发现工作温度希捷的稍微比西数的要高些。不过两者硬盘性能似乎没有区别，组 Raid1 运行相互之间不会有谁拖谁的后腿之说。


## 硬件&改造

NAS 属于不折腾的那种硬件，稳定第一。但由于通常都是放在不起眼的地方，灰尘和散热都是我所担心的，毕竟宝贵的数据全部在这小东西的肚子里。

群晖 212J 的原有风扇是 Y.S.Tech
的，从购买至今使用起来一直都很勤勤恳恳，对它唯一诟病的地方就是声音和振动都有点大
。思前想去，毕竟风扇是 NAS 唯一的主动散热设备，所以还是咬咬牙从淘宝上购买了
[SANYO DENKI 的 9S 风扇（俗称「9S」）](http://s.taobao.com/search?q=SANYO+9s+%B7%E7%C9%C8)。

这个风扇相信玩家都会认识，无论从风噪还是可靠性来讲都比原先的风扇好太多（当然价格也是原有风扇的两倍）。

![http://files.gracecode.com/2014_11_03/1415001521.jpg](http://files.gracecode.com/2014_11_03/1415001521.jpg)

同时购买了快散热片加装到了原有主板的主控芯片上，其实这部没多大必要但装了也总比没有要好。

![http://files.gracecode.com/2014_11_03/1415001568.jpg](http://files.gracecode.com/2014_11_03/1415001568.jpg)

![http://files.gracecode.com/2014_11_03/1415001634.jpg](http://files.gracecode.com/2014_11_03/1415001634.jpg)

顺便给风扇加装了块滤尘网，同时在各个出风口上用双面胶粘贴了防尘垫，用于一般基本的防尘。最后，在安装硬盘的螺丝上加装了橡胶垫子，这里再次感谢下卖家的小心思，替我考虑得很周到。

经过这些步骤以后，重新合上盖子的时候感觉密封性更好了，希望能够使用得更久些。


## 迁移数据

恢复原有 Raid1 盘的内容并不轻松，我没有使用 [Synology Hybrid RAID](https://www.synology.com/zh-cn/knowledgebase/tutorials/492) （[幸好没用，这玩意很坑](http://www.mobile01.com/topicdetail.php?f=494&t=2538441)），原先认为使用 USB 硬盘盒接上即可读取，发现行不通。

搜索了下，后来才知道群晖的 Raid1 是 Raid1 。于是将原先 NAS 的其中一块硬盘挂在 Linux 下。

先安装必要的软件

```
apt-get install mdadm lvm2
```

安装完成以后查看硬盘的分区

```
fdisk -l /dev/sdb
```

![http://files.gracecode.com/2014_10_31/1414750074.png
](http://files.gracecode.com/2014_10_31/1414750111.png)

发现有几个分区块，先测试下最大得分区块

```
mdadm --examine /dev/sdb5
```

![http://files.gracecode.com/2014_10_31/1414750097.png
](http://files.gracecode.com/2014_10_31/1414750111.png)

发现的确是软件 Raid1 分区，接下来映射成块设备

```
mdadm -A -R /dev/md9 /dev/sdb5
```

其实到达这一步，使用其他分区格式的可以直接使用 /dev/md9 设备 mount 到系统了，但是群晖使用了 LVM 分区，因此还需要多几个步骤。

```
vgscan && vgchange -ay vg1
```

激活逻辑卷，然后系统会提示你卷下有几个分区，然后用这些映射设备 mount 即可。

```
mount /dev/vg1/volume1 /media/hd
```

![http://files.gracecode.com/2014_10_31/1414750111.png
](http://files.gracecode.com/2014_10_31/1414750111.png)

然后在 NAS 上开个 NFS 分区也一并 mount 过来就可以拷贝文件了。

后来发现有网友[直接使用 NAS 的 Raid1 的恢复迁移数据](http://www.gebi1.com/thread-79548-1-1.html)，早知道这个方法会方便很多。

下面是些参考资料：

- https://en.wikipedia.org/wiki/Logical_Volume_Manager_(Linux)
- http://www.chiphell.com/forum.php?mod=viewthread&tid=708972
- http://www.linux-sxs.org/storage/fedora2ubuntu.html
- https://blog.sleeplessbeastie.eu/2012/05/08/how-to-mount-software-raid1-member-using-mdadm/
- http://serverfault.com/questions/451781/mounting-an-old-lvm-hard-drive-in-fedora-17-gives-error-message

## Tips

差不多是最后了，数据方面的迁移和保存毕竟是很谨慎的事情，下面总结下小的 Tips 也算是经验总结了。

- 数据定期使用移动硬盘联机备份，虽然是 Raid1 但也不排除同时出问题的情况
- 关闭所有可以设置为自动更新的选项，其中包括系统、软件包等
- 硬件方面 NAS 最怕的还是散热和灰尘，当然还有电流
- 不要把 NAS 放在任何人员嘈杂的地方，有条件的还是将其放入深闺中吧

接下来考虑是否购入台 UPS 将 NAS 接入到不间断电源中，出于预算考虑估计还得缓缓 :^)

```-- eof --```
