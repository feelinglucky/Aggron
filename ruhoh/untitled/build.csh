#!/bin/csh

set  css_file = "stylesheets/styles.css"
set less_file = "media/styles.less"

if ( -f $css_file ) then
    rm -f $css_file
endif

if ( ! -f $less_file ) then
    echo "$less_file not exists"
    exit -1;
endif

lessc $less_file >! $css_file 

if ( -f $css_file ) then
    yui-compressor $css_file
endif

