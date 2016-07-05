<?php

$url = "http://cultura.gencat.net/agenda/fitxa.asp?fitxa_id=8863";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$data = curl_exec($ch);

echo $data;

curl_close($ch);

?>