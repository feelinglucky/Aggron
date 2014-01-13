#!/usr/bin/env tcsh

set RSYNC_OPT = "-zvrtpL --progress --delete --password-file=$HOME/.rsync_pass"
#set RSYNC_OPT = "${RSYNC_OPT} --exclude-from "

set RSYNC_SRC = "../compiled/"
set RSYNC_DST = "mingcheng@ramhost::www.gracecode.com"

rsync $RSYNC_OPT $RSYNC_SRC $RSYNC_DST 

