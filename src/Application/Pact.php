<?php

namespace Pact\Phpacto\Application;

use Pact\Phpacto\Domain\Matching\EachLike;
use Pact\Phpacto\Domain\Matching\Like;
use Pact\Phpacto\Domain\Matching\Term;

/**
 * Class Pact - Main class for building motchers.
 *
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class Pact
{
    /**
     * Returns new Term matching.
     *
     * @param $generate
     * @param $matcher
     *
     * @return Term
     *
     * @link https://github.com/realestate-com-au/pact/wiki/v2-flexible-matching
     */
    public static function term($generate, $matcher)
    {
        return new Term($generate, $matcher);
    }

    /**
     * Returns new Like matching.
     *
     * @param $likeValue
     *
     * @return Like
     *
     * @link https://github.com/realestate-com-au/pact/wiki/v2-flexible-matching
     */
    public static function like($likeValue)
    {
        return new Like($likeValue);
    }

    /**
     * Return new EachLike matching.
     *
     * @param array|object $contents
     * @param int          $min
     *
     * @return EachLike
     *
     * @link https://github.com/realestate-com-au/pact/wiki/v2-flexible-matching
     */
    public static function eachLike($contents, $min = 1)
    {
        return new EachLike($contents, $min);
    }
}
