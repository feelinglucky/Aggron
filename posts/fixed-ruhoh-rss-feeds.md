---
title: 修复 Ruhoh 1.1 的 RSS 输出
date: '2012-11-14'
layout: post
categories:
    - 奇技淫巧 
---

正如各位所见，本博客改成了 [Ruhoh 静态博客](http://ruhoh.com/)。有个问题就是 RSS 输出的时候会连页面元素等不必要的元素都一起输出，格式很混乱看着也不是很美观。

因此，就想更改下其中的代码，于是找到了 Ruhoh 脚本的安装路径，例如在我的 Mac 上面是如下路径（下面称这个目录为 ```$RUHOH_HOME``` ）。

    /usr/local/lib/ruby/gems/1.9.1/gems/ruhoh-1.1/lib/ruhoh

分析生成的 RSS 的脚本，文件在 ```$RUHOH_HOME/compilers/rss.rb``` ，其中有段语句是

    xml.description_ (post['description'] ? post['description'] : page.render)

虽然不是很懂 Ruby，但是可以理解它是将页面渲染以后的代码都传了过去，那么再看看这个方法是怎么写的。找到了对应的文件在 $RUHOH_HOME/page.rb 下，里面的 render 方法：

    def render
      self.ensure_id
      self.process_layouts
      @templater.render(self.expand_layouts, self.payload)
    end

其中 self.expand_layouts 的方法就是或许当前的 layout 然后配合 Markdown 渲染出我们需要的 HTML，那么我考虑就不要模板，直接输出。

所以新增了个方法，simple_render ，代码如下：

    def simple_render
      self.ensure_id
      self.process_layouts
      @templater.render("\{\{\{content\}\}\}", self.payload)
    end

最后，修改 ```$RUHOH_HOME/compilers/rss.rb``` 文件对应的上述行：

    xml.description_ (post['description'] ? post['description'] : page.simple_render)

这样就可以不用任何模板直接输出正文内容了，虽然看起来「不干净」但至少「It Works」。

顺便[提供下修改以后的脚本文件](http://files.gracecode.com/2012_11_14/1352879227.zip)，覆盖对应的文件即可，**只针对 Ruhoh 1.1 版本**，希望作者能够尽快修复这个问题吧。


```-- eof --```
