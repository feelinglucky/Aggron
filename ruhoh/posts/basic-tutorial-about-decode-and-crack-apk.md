---
title: 'Android 的 apk 包的反编译和破解初步'
date: '2013-11-28'
layout: post
categories:
    - Android
---

_注：此信息仅仅是作为技术研究使用，请勿用作非法用途。同时本团队的应用已经针对破
解有了对应的措施，并保留追求责任的权利。_


前些日子看到公司的应用被破解同时在论坛里流出，所以了解了下 Android 相应的应用破解原理以及过程。

首先，下载相应解开 apk 的工具包：

[https://code.google.com/p/android-apktool/](https://code.google.com/p/android-apktool/)

下载完了以后得到个 jar 包，我们运行

	java -jar apktool.jar

就可以得到它的用法。我这边直接解压缩相应的 apk 包：

	java -jar apktool.jar decode origin-v1.0.apk

解压完毕以后，在本地目录就可以看到多出来个文件夹，里面包含了 apk 的原始资源等数据。

![http://files.gracecode.com/2013_11_28/1385608157@640.png](http://files.gracecode.com/2013_11_28/1385608157@640.png)

其中，最重要的就是 smali 目录，它对应的是原始 Android 项目的 src 目录，也就是 Java 源文件。不过 smali 有点类似「Java 的汇编」，详细有关 smali 的信息可以在这里得到：

[https://code.google.com/p/smali/](https://code.google.com/p/smali/)

下面，比如我们已经知道原来应用注册的位置，例如 Activity 的入口，那么我们就从这里开始切入。

![http://files.gracecode.com/2013_11_28/1385608119.png](http://files.gracecode.com/2013_11_28/1385608119.png)

我们很容易得就能得到相应的激活注册模块的方法在哪里，例如下面的 parseActive 方法就是判断 JSONObject 是否包含了注册信息。

	.method public static parseActive(Lorg/json/JSONObject;)Lcn/dxy/android/medicinehelper/api/model/Active;

从大体的阅读源码来看，这个方法主要的功能就是解析服务器返回的 JSON 信息，然后根据返回判断是否注册。那么，我的思路就是修改方法，无论服务器返回什么都返回已经注册。

![http://files.gracecode.com/2013_11_28/1385608183.png](http://files.gracecode.com/2013_11_28/1385608183.png)

看程序代码段中，有段为


    .line 35
    const-string v3, "active"

    invoke-static {p0, v3, v4}, Lcn/dxy/sso/util/AppUtil;->getJsonBooleanValue(Lorg/json/JSONObject;Ljava/lang/String;Z)Z

    move-result v1

    .line 36
    .local v1, active:Z
    if-nez v1, :cond_0

    .line 37
    invoke-static {p0}, Lcn/dxy/sso/entity/ErrorType;->constructErrorBody(Lorg/json/JSONObject;)Lcn/dxy/sso/entity/ErrorType;

    move-result-object v2


其中，有个语句 `if-nez v1, :cond_0` 很关键，因为这个语句下面就是错误信息了（v1 的值是 JSONOBject 过来的 activte 字段的内容）。那么可以判断，这个 if 就是主要判断语句，写成伪代码也就是

```
if (!active) {
	showError();
	return;
}

// Activited
```

所以我将这个判断的内容始终改成 true，查询 smali 的语法，简单的修改如下

    if-eqz v1, :cond_0
    
也就是做了个相反的判断，虽然这样子正常的激活码就无法注册，但根据逻辑只要输入格式对应的激活码都可以激活了。

修改完成了以后我们需要重新打包成 apk 文件，这里还是要用到上述的 apktool 工具，做个相反的操作即可：

	java -jar apktool.jar build <origin-v1.0-dir> new-v1.0.apk

注意，这时通过 apktool 生成的 apk 文件是没有经过签名的，直接 `adb install` 是无法
安装的，会报 `INSTALL_PARSE_FAILED_NO_CERTIFICATES` 错误。

因此，我们需要将其前面以后再安装，这里有 Google 相应的文档阐述如何签名 apk 包：
    
    https://developer.android.com/tools/publishing/app-signing.html

当然使用了自定义前面的 apk 包以后您就无法安装和升级官方的 apk 包了。


![http://files.gracecode.com/2013_11_28/1385608067@640.png](http://files.gracecode.com/2013_11_28/1385608067@640.png)


完成上述步骤了以后，我们安装打开已经经过修改的应用，发现随便输入任何激活码就可以完成本地激活了。 


`- eof -`

