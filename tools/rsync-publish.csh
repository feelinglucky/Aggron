#!/usr/bin/env tcsh

set RSYNC_OPT = "-zvrtpL --progress --delete --password-file=$HOME/.rsync_pass"
#set RSYNC_OPT = "${RSYNC_OPT} --exclude-from "

set RSYNC_SRC = "~/Projects/aggron/compiled/"
set RSYNC_DST = "mingcheng@otomo.gracecode.com::static"

rsync $RSYNC_OPT $RSYNC_SRC $RSYNC_DST 

