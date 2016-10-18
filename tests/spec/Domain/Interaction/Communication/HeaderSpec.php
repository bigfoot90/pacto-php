<?php

namespace spec\Pact\Phpacto\Domain\Interaction\Communication;

use Pact\Phpacto\Domain\Interaction\Communication\Header;
use Pact\Phpacto\PactException;
use PhpSpec\ObjectBehavior;

/**
 * Class HeaderSpec.
 *
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 * @mixin Header
 */
class HeaderSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Pact\Phpacto\Domain\Interaction\Communication\Header');
    }

    public function it_should_return_empty_jsonSerialize()
    {
        $this->jsonSerialize()->shouldReturn([]);
    }

    public function it_should_add_key_value()
    {
        $this->beConstructedWith(['name' => 'Franek']);

        $this->jsonSerialize()->shouldReturn([
            'name' => 'Franek',
        ]);
    }

    public function it_should_add_multiple_key_values()
    {
        $this->beConstructedWith([
            'name' => 'Franek',
            'surname' => 'Edwin',
        ]);

        $this->jsonSerialize()->shouldReturn([
            'name' => 'Franek',
            'surname' => 'Edwin',
        ]);
    }

    public function it_should_throw_exception_if_empty_key_or_value_passed()
    {
        $this->shouldThrow(PactException::class)->during('__construct', [['name' => '']]);
        $this->shouldThrow(PactException::class)->during('__construct', [['' => 'some']]);
        $this->shouldThrow(PactException::class)->during('__construct', [['' => '']]);
    }
}
