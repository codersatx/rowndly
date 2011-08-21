<?php

$url = $_GET['url'];
$url = parse_url($url);
$host = $url['host'];
$path = str_replace('/', '--', $url['path']);
$ipad = isset($_GET['ipad']) ? $_GET['ipad'] : '';

header('Location: /rownds/post/'.$host.'/'.$path.'/'. $ipad);

