#!/bin/bash

./turnCamOff.sh
screen -d -m streamer -r 1 -t 2000000 -s 576x360 -j 100 -o snapshots/snap00000000.jpeg
