#!/bin/sh

if [ "$#" != 2 ]; then
  echo "usage: `basename "$0"` [ip|host] port" >&2
  exit 1
fi

time siege -d10 -c10 "$1:$2"
