<?php
$user_id = $_GET['user_id'];
$url = $_GET['url'];
$url = parse_url($url);
$host = $url['host'];
$path = str_replace('/', '--', $url['path']);

header('Location: /ipad/post/'.$user_id.'/'.$host.'/'.$path);