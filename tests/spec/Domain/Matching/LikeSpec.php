<?php

namespace spec\Pact\Phpacto\Domain\Matching;

use Pact\Phpacto\Domain\Matching\Like;
use PhpSpec\ObjectBehavior;

/**
 * Class SomethingLikeSpec.
 *
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 * @mixin Like
 */
class LikeSpec extends ObjectBehavior
{
    private $likeValue;

    public function let()
    {
        $this->likeValue = 10;
        $this->beConstructedWith($this->likeValue);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(\JsonSerializable::class);
    }

    public function it_should_return_as_ruby_object()
    {
        $this->jsonSerialize()->shouldReturn([
            'json_class' => 'Pact::SomethingLike',
            'contents' => $this->likeValue,
        ]);
    }
}
