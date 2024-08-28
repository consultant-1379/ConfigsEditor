#!/bin/bash

if [[ $# -lt 1 ]]
then
        echo "Usage: $0 logname "
        exit 1
fi

FILENAME=$1
TAIL=$2
if [[ "$TAIL_SIZE" == "" ]]
then
        TAIL_SIZE=80
fi

FILE_DIR=`dirname $FILENAME`
if [[ $TAIL != "true" && ( -f $FILE_DIR/.completed || -f $FILE_DIR/../.completed || -f $FILE_DIR/../../.completed ) ]]
then
    echo "FULLLOG"
    echo "<pre>"
    #cat $FILENAME | ./ansi2html.sh --bg=dark
    cat $FILENAME | /usr/local/bin/ansi2html --input-encoding=ISO-8859-1 -p
    echo "</pre>"
else
    echo "<pre>"
    #tail -$TAIL_SIZE $FILENAME | ./ansi2html.sh --bg=dark
    tail -$TAIL_SIZE $FILENAME | /usr/local/bin/ansi2html --input-encoding=ISO-8859-1 -p
    echo "</pre>"
fi