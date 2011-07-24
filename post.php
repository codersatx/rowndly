<?php

$url = $_GET['url'];
$url = parse_url($url);
$host = $url['host'];
$path = str_replace('/', '--', $url['path']);

header('Location: /rownds/post/'.$host.'/'.$path);
//print_r($url);
