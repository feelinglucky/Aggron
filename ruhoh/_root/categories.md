---
layout: page
description: Global category lists.
---

<ul class="tag_box inline">
    {{# posts.categories.all }}
        {{> categories_list }}
    {{/ posts.categories.all }}
</ul>

{{# posts.categories.all }}
<h2 id="{{ name }}-ref">{{ name }}({{ count }})</h2>
<ul>
    {{# posts?to_posts }}
        {{> posts_list }}
    {{/ posts?to_posts }}
</ul>
{{/ posts.categories.all }}
