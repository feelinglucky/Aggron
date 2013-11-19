---
title: Volley 使用笔记
date: '2013-11-19'
layout: post
categories:
    - Android
---




Google I/O 2013 上就讲到了 Volley。当时并没还有在意这个类库，直到看了某项目的源代码后，发现这个东西值得推荐。

Volley 这个库的官方介绍是：

	Volley is a library that makes networking for Android apps
	easier and most importantly, faster.

不是很严谨的讲，Volley 就是个包含了很多封装功能的网络请求工具类。使用这个工具类有个优势就是可以节省很多在请求以及缓存方面的开发时间。


### 优势



[相比其他网络载入类库](https://github.com/nostra13/Android-Universal-Image-Loader
)，Volley 的优势官方主要提到如下几点：

1. 队列网络请求，并自动合理安排何时去请求。
2. 提供了默认的磁盘和内存等缓存(Disk Caching & Memory Caching)选项。
3. Volley 可以做到高度自定义，它能做到的不仅仅是缓存图片等资源。
4. Volley 相比其他的类库更方便调试和跟踪。



## 基本使用

引入 Volley 很简单。使用 git 下载代码到本地

	git clone https://android.googlesource.com/platform/frameworks/volley

然后引入到项目中就可以使用了。

Volley 简单的来讲主要由两个类控制：

1. Request Queue
2. Request

Volley 的「Hello，World」示例代码：

	// 实例化 Request Queue
	RequestQueue queue = Volley.newRequestQueue(context);

	// 实例化 Request
	String url = "<remote url>";
	JsonObjectRequest jsonObjRequest =
		new JsonObjectRequest(Request.Method.GET, url, null, new Response.Listener<JSONObject>() {

			@Override
			public void onResponse(JSONObject response) {
				// ...
			}
		}, new Response.ErrorListener() {

			@Override
			public void onErrorResponse(VolleyError error) {
				// ...

			}
		});

然后剩下要做的事情就是把这个 Request 扔到 Queue 里面即可：

	queue.add(jsonObjRequest);


## 缓存图片资源

缓存图片资源 Volley 提供了个自定义的 NetworkImageView 继承自 ImageView 。它的优势就是载入远程图片几乎可以用「傻瓜」形容，例如：

	mNetworkImageView.setImageUrl(imageUrl, new ImageLoader());

其中 ImageLoader 最重要的一个参数就是 ImageLoader.ImageCache 它控制是否需要请求网络获取数据。因此，我们可以将这个 Class 配合 LruCache 以及 DiskLruCache 用来内存和磁盘缓存。

主要方法

    @Override
    public Bitmap getBitmap(String url) {
        Bitmap data = mLruCache.get(url);
        if (data == null) {
            try {
                data = mDiskLruCache.get(key);
                if (data != null) {
                    mLruCache.put(key, data);
                }
            } catch (IOException e) {
                e.printStackTrace();
            }
        } 

        return data;
    }


这样子，就可以很清晰得把内存缓存和磁盘缓存之间的关系建立和链接起来了。



## 资源&参考

* http://java.dzone.com/articles/android-%E2%80%93-volley-library
* https://developers.google.com/events/io/sessions/325304728
* https://www.youtube.com/watch?v=yhv8l9F44qo
* https://android.googlesource.com/platform/frameworks/volley

`- eof -`


