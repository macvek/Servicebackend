#!/bin/bash

while true; 
do 
  sleep 1;

  if [ -e daemoncmd/on ] 
  then
    ./turnCamOn.sh
    rm -f daemoncmd/on
  fi 

  if [ -e daemoncmd/off ]
  then
    ./turnCamOff.sh
    ./archiveSnapshots.sh 
    ./archiveSnapshotsGC.sh 
    rm -f daemoncmd/off
  fi

  if [ -e daemoncmd/stop ]
  then
    rm -f daemoncmd/stop
    exit
  fi
done
