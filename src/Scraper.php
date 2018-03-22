<?php

namespace Scraper;
use Scraper\Matches\FileMatch;

class Scraper
{
    /**
     * @var File
     */
    private $file;

    /**
     * Constructor
     *
     * @param FileMatch $file
     */
    public function __construct(FileMatch $file)
    {
        $this->file = $file;
    }

    /**
     * Scrape file
     *
     * @return array
     */
    public function scrape()
    {
        $results = [];
        $total = 0;

        foreach ($this->file->getArticles() as $article) {
            if ($article !== null) {
                foreach ($article->getLinks() as $link) {
                    if ($link !== null) {
                        $size = round($link->getSize() / 1024, 1);
                        $total += $size;
                        $results[] = [
                            'filesize' => $size . 'kb',
                            'keywords' => $link->getKeywords(),
                            'link' => $link->getLinkText(),
                            'meta description' => $link->getDescription(),
                            'url' => $link->getFilename(),
                        ];
                    }
                }
            }
        }

        return [
            'results' => $results,
            'total' => $total . 'kb'
        ];
    }
}
