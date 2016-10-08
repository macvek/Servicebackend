#!/bin/bash

NUM=`date +"%s"`

FILENAME=archives/snaparchive_$NUM.tar 
if [ -e $FILENAME ]
then
  echo "archive already exists"
else
  tar -c -f $FILENAME snapshots
  rm snapshots/*.jpeg
fi
