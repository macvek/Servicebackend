#!/bin/bash

SIZELIMIT=140
SIZE=0
LIST=`du archives`
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

