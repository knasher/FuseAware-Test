#!/usr/bin/php
<?php

require './vendor/autoload.php';

if (count($argv) < 2) {
    die('Please provide a filename to write the JSON' . chr(10));
}

$options = getopt('u::', ['url::']);

$url = 'http://www.black-ink.org';

if (isset($options['url']) && is_string($options['url'])) {
    $url = $options['url'];
}

if (isset($options['u']) && is_string($options['u'])) {
    $url = $options['u'];
}

$file = new \Scraper\Matches\FileMatch($url);

$scraper = new \Scraper\Scraper($file);
$data = $scraper->scrape();

$json = json_encode($data);

file_put_contents($argv[1], $json);
