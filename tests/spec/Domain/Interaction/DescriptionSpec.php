<?php

namespace spec\Pact\Phpacto\Domain\Interaction;

use Pact\Phpacto\Domain\Interaction\Description;
use Pact\Phpacto\PactException;
use PhpSpec\ObjectBehavior;

/**
 * Class DescriptionSpec.
 *
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 * @mixin Description
 */
class DescriptionSpec extends ObjectBehavior
{
    /** @var  string */
    private $description;

    public function let()
    {
        $this->description = 'A request for foo';
        $this->beConstructedWith($this->description);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(\JsonSerializable::class);
    }

    public function it_should_return_description()
    {
        $this->jsonSerialize()->shouldReturn($this->description);
    }

    public function it_should_throw_exception_if_empty_value_passed()
    {
        $this->shouldThrow(PactException::class)->during('__construct', ['']);
    }
}
