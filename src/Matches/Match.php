<?php

namespace Scraper\Matches;
use Scraper\Exceptions\RegularExpressionFailedException;
use Scraper\Exceptions\RegularExpressionNoMatchesException;

abstract class Match
{
    /**
     * Match from pattern in subject
     *
     * @param string $pattern
     * @param string $subject
     * @param boolean $checkMatches
     *
     * @throws RegularExpressionFailedException
     * @throws RegularExpressionNoMatchesException
     * @return array
     */
    protected function match($pattern, $subject, $checkMatches = false)
    {
        $result = preg_match($pattern, $subject, $matches);

        if ($result === false) {
            throw new RegularExpressionFailedException();
        }

        if ($checkMatches && $result == 0) {
            throw new RegularExpressionNoMatchesException();
        }

        return $matches;
    }

    /**
     * Match all from pattern in subject
     *
     * @param string $pattern
     * @param string $subject
     * @param integer $flags
     * @param boolean $checkMatches
     *
     * @throws RegularExpressionFailedException
     * @throws RegularExpressionNoMatchesException
     * @return array
     */
    protected function matchAll($pattern, $subject, $flags = PREG_PATTERN_ORDER, $checkMatches = false)
    {
        $result = preg_match_all($pattern, $subject, $matches, $flags);

        if ($result === false) {
            throw new RegularExpressionFailedException();
        }

        if ($checkMatches && $result == 0) {
            throw new RegularExpressionNoMatchesException();
        }

        return $matches;
    }
}
