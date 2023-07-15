#!/usr/bin/sh

php -S 0.0.0.0:0&
APP_PID=$!
sleep 1
PORT=`lsof -i -P |grep $APP_PID | awk '{split($0, a, ":"); print a[2]}' | sed s/[^0-9]//g`
echo "Your Port is: \033[32m$PORT\033[0m"
kill $APP_PID