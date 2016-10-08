#!/bin/bash

while true; 
do 
  sleep 1;

  if [ -e daemoncmd/on ] 
  then
    ./turnCamOn.sh
    rm daemoncmd/on
  fi 

  if [ -e daemoncmd/off ]
  then
    ./turnCamOff.sh
    ./archiveSnapshots.sh 
    ./archiveSnapshotsGC.sh 
    rm daemoncmd/off
  fi

  if [ -e daemoncmd/stop ]
  then
    rm daemoncmd/stop
    exit
  fi
done
