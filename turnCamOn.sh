#!/bin/bash

./turnCamOff.sh
screen -d -m streamer -r 1 -t 2000000 -s 1152x720 -j 100 -o snapshots/snap00000000.jpeg
