# scanning for wifi, getting location by wifi networks from goolge API, sending location to server.
# needs to be run as root

#!/bin/bash

source config.sh

api_head="{
  \"considerIp\": \"false\",
  \"wifiAccessPoints\": ["

api_content="    {
        \"macAddress\": \"AddressToken\",
        \"signalStrength\": SignalToken,
        \"signalToNoiseRatio\": 0
    },"

api_end="{
        \"macAddress\": \"\"
    }
  ]
}"

api_request="$api_head"

result="$(iwlist scan | paste -s -d'_')"

result="$(echo -e "${result}" | tr -d '[:space:]')"

arr=(${result//Cell/ })


for i in "${arr[@]}"; do
if [[ $i == *"Address"* ]]; then
    address=${i##*Address:}
    address=${address%%_Channel*}
#    echo "$address"
    signal=${i##*Signallevel=}
    signal=${signal%%dBm_*}
#    echo "$signal"
api_content_temp="${api_content/AddressToken/$address}"
api_content_temp="${api_content_temp/SignalToken/$signal}"
api_request+="$api_content_temp"

fi
done
api_request+="$api_end"

#echo "$api_request"

echo "$api_request" > "$api_request_dir"

api_response=$(curl -d @"$api_request_dir" -H "Content-Type: application/json" -i "https://www.googleapis.com/geolocation/v1/geolocate?key=$api_key")

curl --data "coords=$api_response" "$upload_url"
