<?php

namespace Scraper\Matches;
use Scraper\Exceptions\FileNotFoundException;
use Scraper\Exceptions\RegularExpressionNoMatchesException;

class ArticleMatch extends Match
{
    /**
     * @var bool
     */
    private $digitalia;

    /**
     * @var string
     */
    private $html;

    public function __construct($html)
    {
        $this->html = $html;

        $url = $this->getUrlFromFooter();
        $this->digitalia = $this->isPartInUrlPath($url, 'workblog');
    }

    public function getLinks()
    {
        $matches = $this->matchAll('/<a.*?href="(.*?)".*?>(.*?)<\/a>/si', $this->html, PREG_SET_ORDER);

        return array_map(
            function($match)
            {
                try {
                    $file = new FileMatch($match[1], $match[2]);
                } catch (FileNotFoundException $e) {
                    return null;
                }

                return $file;
            },
            $matches
        );
    }

    public function isDigitalia()
    {
        return $this->digitalia;
    }

    /**
     * Get url from article footer html
     *
     * @return string
     */
    private function getUrlFromFooter()
    {
        try {
            $matches = $this->matchAll(
                '/<footer.*?>.*?href="(.*?)".*?<\/footer>/si',
                $this->html,
                PREG_PATTERN_ORDER,
                true
            );
        } catch (RegularExpressionNoMatchesException $e) {
            return '';
        }

        return $matches[1][0];
    }

    /**
     * Looks for part in url path
     *
     * @param string $url
     * @param string $part
     *
     * @return bool
     */
    private function isPartInUrlPath($url, $part)
    {
        $path = parse_url($url, PHP_URL_PATH);
        $path = trim($path, '/');

        $pathParts = explode('/', $path);

        if (in_array($part, $pathParts)) {
            return true;
        }

        return false;
    }
}
