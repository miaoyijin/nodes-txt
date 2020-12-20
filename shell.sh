#!/bin/bash
for ((i=1; i<400; i++))
do
    /opt/app/php/bin/php /opt/case/github/nodes-txt/tcp_ip/http/curl_http.php  >> log.txt &
done