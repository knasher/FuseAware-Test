<?php

namespace Scraper\Matches;
use Scraper\Exceptions\FileNotFoundException;

class FileMatch extends Match
{
    /**
     * @var string
     */
    private $contents;

    /**
     * @var string
     */
    private $filename;

    /**
     * @var string
     */
    private $linkText;

    /**
     * Constructor
     *
     * @param string $filename
     * @param string $text
     */
    public function __construct($filename, $linkText = null)
    {
        $this->load($filename);
        $this->linkText = $linkText;
    }

    /**
     * Get articles
     *
     * @return array
     */
    public function getArticles()
    {
        $matches = $this->matchAll('/<article.*?>.*?<\/article>/si', $this->contents);

        return array_map(
            function($match)
            {
                $article = new ArticleMatch($match);

                if (!$article->isDigitalia()) {
                    return null;
                }

                return $article;
            },
            $matches[0]
        );
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        $matches = $this->match('/<meta.*?name=["|\']description["|\'].*?>/', $this->contents);

        if (count($matches) != 1) {
            return '';
        }

        return $this->getMetaContent($matches[0]);
    }

    /**
     * Get filename
     *
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Get keywords
     *
     * @return string
     */
    public function getKeywords()
    {
        $matches = $this->match('/<meta.*?name=["|\']keywords["|\'].*?>/', $this->contents);

        if (count($matches) != 1) {
            return '';
        }

        return $this->getMetaContent($matches[0]);
    }

    /**
     * Get link text
     *
     * @return string
     */
    public function getLinkText()
    {
        return $this->linkText;
    }

    /**
     * Get size of contents in bytes
     *
     * @return integer
     */
    public function getSize()
    {
        return strlen($this->contents);
    }

    /**
     * Get meta content
     *
     * @param string $metaTag
     *
     * @return string
     */
    private function getMetaContent($metaTag)
    {
        $matches = $this->match('/<meta.*?content=["|\'](.*?)["|\'].*?>/', $metaTag);

        if (count($matches) != 2) {
            return '';
        }

        return $matches[1];
    }

    /**
     * Load file from filename
     *
     * @param string $filename
     *
     * @throws FileNotFoundException
     */
    private function load($filename)
    {
        $this->filename = $filename;

        $contents = @file_get_contents($filename);

        if ($contents === false) {
            throw new FileNotFoundException();
        }

        $this->contents = $contents;
    }
}
