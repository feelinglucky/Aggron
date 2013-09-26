---
title: '使用命令行截取 Android 设备的界面'
date: '2013-08-23'
categories:
    - Android
---

在进行 Android 开发的时候有时候需要截图，通常我的土办法就是打开 DDMS 然后再截取，这样有点不好就是效率不高每次都需要刷新然后手工去保存。


搜索了下，发现 [Linux 下已经有现成的解决方案](http://blog.shvetsov.com/2013/02/grab-android-screenshot-to-computer-via.html
)。原理就是使用使用 Android 自带的命令行 screencap 然后通过 adb 传输过来。

整条 Shell 命令其实很简单

```
adb shell screencap -p | sed 's/\r$//' > outputs.png
```

但发现在我的 Mac 无法运行。检查了以后发现是 [GNU sed 和 BSD sed 命令间有不兼容的情况](http://stackoverflow.com/questions/4247068/sed-command-failing-on-mac-but-works-on-linux)。我的解决方案就是使用 [brew](http://brew.sh/) 安装 gsed（有更好的解决方案的同学欢迎指出）。

```
brew install gnu-sed
```

然后简单得修改下上面的 Shell 脚本：

```
adb shell screencap -p | gsed 's/\r$//' > ~/Desktop/`date +%Y%m%d%H%M%S.png`
```

这样子每次运行这个脚本就能把 Android 设备的截图放到桌面了，并自动命名。

### UPDATE .1

原博客的作者也给出了在 Mac 下的解决方案，他是使用 Perl ：

````
adb shell screencap -p | perl -pe 's/\x0D\x0A/\x0A/g' > screen.png
````

这样子对于没有安装 brew 的同学是个好消息。

```-- EOF --```
