<?php

namespace spec\Pact\Phpacto\Domain\Interaction;

use Pact\Phpacto\Domain\Interaction\ProviderState;
use Pact\Phpacto\PactException;
use PhpSpec\ObjectBehavior;

/**
 * Class ProviderStateSpec.
 *
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 * @mixin ProviderState
 */
class ProviderStateSpec extends ObjectBehavior
{
    /** @var  string */
    private $value;

    public function let()
    {
        $this->value = 'A request for foo';
        $this->beConstructedWith($this->value);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(\JsonSerializable::class);
    }

    public function it_should_return_value()
    {
        $this->jsonSerialize()->shouldReturn($this->value);
    }

    public function it_should_throw_exception_if_empty_value_passed()
    {
        $this->shouldThrow(PactException::class)->during('__construct', ['']);
    }
}
