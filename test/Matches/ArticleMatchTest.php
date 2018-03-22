<?php

namespace Test\Scraper\Matches;
use PHPUnit\Framework\TestCase;
use Scraper\Matches\FileMatch;
use Scraper\Matches\ArticleMatch;

class ArticleMatchTest extends TestCase
{
    public function testCreateArticleMatchReturnsIsDigitaliaTrue()
    {
        $html = '<footer><a href="http://foo.test/workblog">Foo Digitalia</a></footer>';

        $article = new ArticleMatch($html);

        $this->assertEquals(true, $article->isDigitalia());
    }

    public function testCreateArticleMatchReturnsIsDigitaliaFalse()
    {
        $html = '<footer><a href="http://foo.test/photos">Foo Photos</a></footer>';

        $article = new ArticleMatch($html);

        $this->assertEquals(false, $article->isDigitalia());
    }

    public function testArticleWithOneInvalidLinkReturnsOneNull()
    {
        $html = '<a href="test/invalid.html">Invalid</a>';

        $article = new ArticleMatch($html);

        $links = $article->getLinks();

        $this->assertEquals(1, count($links));
        $this->assertNull($links[0]);
    }

    public function testArticleWithOneValidLinkReturnsOneFileMatch()
    {
        $html = '<a href="test/test.html">Valid</a>';

        $article = new ArticleMatch($html);

        $links = $article->getLinks();

        $this->assertEquals(1, count($links));
        $this->assertInstanceOf(FileMatch::class, $links[0]);
    }

    public function testArticleWithLinkReturnsFileMatchWithLinkUrlAndText()
    {
        $html = '<a href="test/test.html">Test Text</a>';

        $article = new ArticleMatch($html);

        $links = $article->getLinks();

        $this->assertEquals('test/test.html', $links[0]->getFilename());
        $this->assertEquals('Test Text', $links[0]->getLinkText());
    }
}
