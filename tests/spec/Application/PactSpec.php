<?php

namespace spec\Pact\Phpacto\Application;

use Pact\Phpacto\Application\Pact;
use Pact\Phpacto\Domain\Matching\EachLike;
use Pact\Phpacto\Domain\Matching\Like;
use Pact\Phpacto\Domain\Matching\Term;
use PhpSpec\ObjectBehavior;

/**
 * Class PactSpec.
 *
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 * @mixin Pact
 */
class PactSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Pact\Phpacto\Application\Pact');
    }

    public function it_should_create_term_matching()
    {
        $term = $this->term('02/11/2013', "/\d{2}\/\d{2}\/\d{4}/");
        $term->shouldHaveType(Term::class);
    }

    public function it_should_create_like_matching()
    {
        $like = $this->like(10);
        $like->shouldHaveType(Like::class);
    }

    public function it_should_create_each_like_matching()
    {
        $eachLike = $this->eachLike([
            'name' => 'Fred',
            'age' => 2,
        ]);

        $eachLike->shouldHaveType(EachLike::class);
        $eachLike->jsonSerialize()->shouldReturn([
            'json_class' => 'Pact::ArrayLike',
            'contents' => [
                'name' => 'Fred',
                'age' => 2,
            ],
            'min' => 1,
        ]);

        $eachLike = $this->eachLike([
            'name' => 'Fred',
        ], 5);

        $eachLike->shouldHaveType(EachLike::class);
        $eachLike->jsonSerialize()->shouldReturn([
            'json_class' => 'Pact::ArrayLike',
            'contents' => [
                'name' => 'Fred',
            ],
            'min' => 5,
        ]);
    }
}
