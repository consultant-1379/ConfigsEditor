#!/bin/bash

if [[ $# -lt 1 ]]
then
        echo "Usage: $0 logname"
        exit 1
fi

DIRNAME=$1

if [[ -f $DIRNAME/.running ]]
then
    cat $DIRNAME/.running
fi