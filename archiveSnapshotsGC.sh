#!/bin/bash

SIZELIMIT=4096
SIZE=0
LIST=`du -m archives`
for I in $LIST
do
  SIZE=$I
  break
done

if [ $SIZE -lt $SIZELIMIT ]
then
    exit
fi

ARCHIVES=`ls archives/snaparchive_*`

for EARLIEST in $ARCHIVES
do
    rm -f $EARLIEST
    break
done

