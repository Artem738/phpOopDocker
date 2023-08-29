<?php

require_once '../src/UrlShortener/AppConfig.php';
require_once '../src/UrlShortener/Interfaces/IUrlEncoder.php';
require_once '../src/UrlShortener/Interfaces/IUrlDecoder.php';
require_once '../src/UrlShortener/UrlProcessor.php';
require_once '../src/UrlShortener/FileRepository.php';
require_once '../src/UrlShortener/UrlCoder.php';
require_once '../src/UrlShortener/UrlValidator.php';

use UrlShortener\UrlProcessor;

$encoder = new UrlProcessor();
$encodedUrl = $encoder->encode("https://www.google.com/");
echo "Encoded URL: $encodedUrl".PHP_EOL;

$decoder = new UrlProcessor();
$decodedUrl = $decoder->decode($encodedUrl);
echo "Decoded URL: $decodedUrl".PHP_EOL;