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

/*
    $html = file_get_contents('http://www.black-ink.org');

    if ($html === false || strlen($html) == 0) {
        die('Cannot find site');
    }

    preg_match_all('/<article.*?>.*?<\/article>/si', $html, $matches);

    if (count($matches[0]) == 0) {
        die('No article matches');
    }

    foreach ($matches[0] as $match) {
        // Check whether this article should be processed
        preg_match_all('/<footer.*?>.*?href="(.*?)".*?<\/footer>/si', $match, $fMatches);

        if (count($fMatches[1]) == 0) {
            continue;
        }

        $url = parse_url($fMatches[1][0]);

        $path = trim($url['path'], '/');
        $pathParts = explode('/', $path);

        if (!in_array('workblog', $pathParts)) {
            continue;
        }

        // Find links
        preg_match_all('/<a.*?href="(.*?)".*?>(.*?)<\/a>/si', $match, $lMatches);

        if (count($lMatches[1]) == 0) {
            continue;
        }

        $i = 0;

        for (;$i < count($lMatches[1]);$i++) {
            $link = $lMatches[1][$i];
            $title = $lMatches[2][$i];

            // Check link
            $lHtml = file_get_contents($link);

            if ($lHtml === false || strlen($lHtml) == 0) {
                continue;
            }

            $description = '';
            $keywords = '';
            $size = strlen($lHtml);

            // Get description
            preg_match('/<meta.*?name=["|\']description["|\'].*?>/', $lHtml, $dMatches);

            if (count($dMatches) > 0) {
                preg_match('/<meta.*?content=["|\'](.*?)["|\'].*?>/', $dMatches[0], $dcMatches);

                $description = $dcMatches[1];
            }

            // Get keywords
            preg_match('/<meta.*?name=["|\']keywords["|\'].*?>/', $lHtml, $kMatches);

            if (count($kMatches) > 0) {
                preg_match('/<meta.*?content=["|\'](.*?)["|\'].*?>/', $kMatches[0], $kcMatches);

                $keywords = $kcMatches[1];
            }

            print_r('Link: ' . $link . chr(10) . 'Title: ' . $title . chr(10) . 'Description: ' . $description . chr(10) . 'Keywords: ' . $keywords . chr(10) . 'Size: ' . $size . 'kb' . chr(10) . chr(10));
        }
    }
*/