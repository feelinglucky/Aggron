---
title: VimWiki 使用笔记
layout: page
---

## 更新记录

* *2012-10-11* 重新使用 Markdown 格式编辑
* *2010-04-13* 增加使用“时间戳”章节
* *2010-03-20* 基本完成此篇文档
* *2010-03-19* 增加“配置”章节
* *2010-03-18* 初始化版本，增加“安装”章节


## 前言

如果你在使用 Vim，那么我敢保证你绝对不会错过这款名为[VimWiki](http://vimwiki.googlecode.com) 的插件。 您使用 VimWiki 可以

* 组织笔记和想法
* 组织行动列表（TODO List）
* 编写文档


## 安装

VimWiki 的项目主页为 [http://vimwiki.googlecode.com ](http://vimwiki.googlecode.com) ，下载压缩文件解压缩后用 Vim 打开，然后

    :source %

即可安装完成。

同时建议 Vim 配置文件中有下面的选项：

    set nocompatible
    filetype plugin on
    syntax on

上述配置的具体解释详细解释看 help 文档。


## 配置

### 配置路径

### 我的 VimWiki 配置

    " VimWiki 配置
    let g:vimwiki_list = [{"path": "~/Wiki/", "path_html": "~/Sites/wiki/", "auto_export": 1}]

其中，path 为 保存 wiki 的文件路径，path_html 为输出 html 的路径，auto_export
设置为自动导出。

### 管理多个 Wiki

管理多个 VimWiki 即在 `g:vimwiki_list` 中增加对应的数组选项即可，如
 
    let g:vimwiki_list = [{"path": "...", "path_html": "..."},
                        \ {...}, ... ]

### 其他配置

    let g:vimwiki_auto_checkbox = 0

设置列表不自动添加 checkbox 框

    let g:vimwiki_w32_dir_enc = 'cp936'

如果在中文版的 Windows 下，目录名称如果为中文，则应用此选项（否则默认使用 Vim
encoding 指定的编码）。


## 使用

### 命令

### Golbal 命令

* :VimwikiGoHome
* :VimwikiTabGoHome
* :VimwikiUISelect
 
### Buffer 命令

* :Vimwiki2HTML
* :VimwikiAll2HTML
* :VimwikiDeleteWord
* :VimwikiDeleteWord
* :VimwikiFollowWord
* :VimwikiGoBackWord
* :VimwikiNextWord
* :VimwikiPrevWord
* :VimwikiRenameWord
* :VimwikiSplitWord
* :VimwikiToggleListItem
* :VimwikiVsplitWord

### 快捷键

    [n]\ww :: 打开第 N 个 Wiki，如果没指定，则打开默认 Wiki
    [n]\wt :: 新标签页打开第 N 个Wiki
    \ws :: 打开 Wiki 列表并选择打开
    <Enter> :: 打开、创建 !WikiWord
    <Shift + Enter> :: 水平分隔并打开、创建 !WikiWord
    <Ctrl + Enter> :: 垂直分割打开、创建 !WikiWord
    <Backspace> :: 回到上一个 !WikiWord
    <Tab> :: 找到下个 !WikiWord
    <Shift-Tab> :: 找到上个 !WikiWord
    \wd :: 删除当前 !WikiWord
    \wr :: 重命名 !WikiWord
    <Ctrl-Space> :: 打开、关闭列表
    = :: 增加、创见标题
    - :: 删除、减少标题

### 语法

#### 章节

    *text* :: 粗体
    _text_ :: 斜体
    ~~text~~ :: 删除线
    ^text^ :: 上标
    ,,text,, :: 下标
    `code` :: 代码、不解析
    <!- - text - -> :: 注释，同时布显示于 HTML 输出

#### 标题

    = header = :: 标题一
    == header == :: 标题二
    === header === :: 标题三
    ==== header ==== :: 标题四
    ===== header ===== :: 标题五
    ====== header ====== :: 标题六

#### 链接

    TextText :: !WikiWord
    !TextText :: 不要链接指定的 !WikiWord
    [[Text text]] :: 强制指定某个 !WikiWord，注意中文等字符
    [[Text text | Text]] :: 使用某个描述到 !WikiWord

下述链接格式可多项组合

    http://site/ :: 自动连接
    [http://site/ home page] :: 带描述的连接
    http://site/pic.jpg :: 解析为图片
    [[images/pic.jpg]] :: 链接到本地图片


#### 列表

##### 无序列表 

    * items
    * items
    * items
    * items

##### 有序列表

    # items
    # items
    # items
    # items

##### 定义列表

    define :: desption
    define :: desption
    define :: desption
    define :: desption

#### 表格

    | 表格 | 表格 | 表格 |
    | 表格 | 表格 | 表格 |
    | 表格 | 表格 | 表格 |


## 技巧

### 同步 Vimwiki

可以考虑使用 Dropbox &amp; rsync 同步 Wiki 文件以及脚本，架构图如下

![同步图例](http://files.gracecode.com/2010_03_20/1269096655.png)


### 生成所有的 HTML

重新生成所有的 HTML 页面（不包括样式）

    :VimwikiAll2HTML


## 附

* [Vimwiki 参考小抄（pdf 格式）](http://vimwiki.googlecode.com/hg/misc/vimwikiqrc.pdf)
* [http://xbeta.info/vimwiki.htm](http://xbeta.info/vimwiki.htm)


### Windows 下路径变错的问题

1、检查 HTML 输出的路径是否正确

    : shellescape(expand('%:p:h'))

2、配置文件文件中，盘符路径必须大写而且最后最好加上目录分隔符，例如

    " 注意！
    " 1、如果在 Windows 下，盘符必须大写
    " 2、路径末尾最好加上目录分隔符
    let s:vimwiki_root = "C:/.../Vimwiki"
    let g:vimwiki_list = [
                \{"path": s:vimwiki_root."/Default/",
                \"path_html": s:vimwiki_root."/Default/html/", "auto_export": 1}
                \]


### 增加 HTML 输出时间戳标记

给 `$VIM_FILES/autoload/vimwiki_html.vim` 打[补丁](http://gracecode.googlecode.com/files/vimwiki_html_vim.patch)。

然后再设置的自定义 footer.tpl 的合适位置中，加入

    %time_stamp%

即可在每份输出的 HTML 中加入时间戳（导出 HTML 的时间）。如果想更改时间戳的格式，更改变量

    g:vimwiki_timestamp_format

即可，例如

    let g:vimwiki_timestamp_format = '%Y-%m-%d %H:%M:%S'


``-- EOF--``
