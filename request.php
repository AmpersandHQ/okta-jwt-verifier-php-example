<?php
$url = $argv[1];
require_once __DIR__ . '/vendor/autoload.php';
$jwt = new \Okta\JwtVerifier\Adaptors\FirebasePhpJwt(null, 120);

$timeStart = microtime(true);
$result = $jwt->getKeys($url);
$timeEnd = microtime(true);
$duration = $timeEnd - $timeStart;

echo "Sent request to $url" . PHP_EOL;
echo "Duration $duration" . PHP_EOL;