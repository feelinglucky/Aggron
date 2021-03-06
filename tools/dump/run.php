<?php

include "www_gracecode_com.php";

$template = <<<EOD
---
title: %s
date: %s
layout: post
categories:
%s
#type: draft
---

%s

EOD;


function find_relationships($cid) {
    global $typecho_relationships;
    $results = array();
    foreach($typecho_relationships as $relatioinship) {
        if ($relatioinship['cid'] == $cid) {
            $mid  = $relatioinship['mid'];
            $meta = get_meta($mid);
            array_push($results, $meta);
        }
    }

    return $results;
}

function get_meta($mid) {
    global $typecho_metas;
    foreach ($typecho_metas as $meta) {
        if ($mid == $meta['mid']) {
            return $meta['name'];
        }
    }
}

function generate_category($categorys) {
    $result = "";
    foreach($categorys as $category) {
        $result .= "    - " . $category . "\n";
    }

    return $result;
}

foreach ($typecho_contents as $typecho_content)  {
    if ($typecho_content['type'] != 'post'){
        continue;
    }
    $cid = $typecho_content['cid'];
    $title = $typecho_content['title'];
    $created = $typecho_content['created'];
    $text = $typecho_content['text'];
    $metas = find_relationships($cid);

    //var_dump($text);
    preg_match_all('/(\ \\\".+?\\\"\))/', $text, $matches);
    //    var_dump($matches); exit;
    if ($matches && !empty($matches[1])) {
        foreach($matches[1] as $match) {
            $text = str_replace($match, ")", $text);
        }
    }
    $text  = str_replace("\r", "", $text);
    $text = str_replace("&quot;", "\"", $text);
    $text = str_replace("&gt;", ">", $text);
    $text = str_replace("&lt;", "<", $text);
    $text = str_replace("&amp;", "&", $text);

    $text = preg_replace('/\n<pre>(.+?)<\/pre>/', "\n    $1", $text); 
    $text = preg_replace('/\n<pre>(.+?)<\/pre>\n/s', "\n```\n$1\n```\n", $text); 
    $text = preg_replace('/http:\/\/www\.gracecode\.com\/archives\/(\d+)\//', "{{site.urls}}/posts/$1/", $text); 


    $title = str_replace("“", "「", $title);
    $title = str_replace("”", "」", $title);

    $data = sprintf($template, 
        $title,
        date('Y-m-d', $created),
        generate_category($metas),
        $text
    );


    $file_name = "./posts/" . $cid . ".md";
    printf($file_name . "\n");
    file_put_contents($file_name, $data);
}
