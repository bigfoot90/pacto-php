<?php

namespace spec\Pact\Phpacto\Domain\Interaction\Communication;

use Pact\Phpacto\Domain\Interaction\Communication\StatusCode;
use Pact\Phpacto\PactException;
use PhpSpec\ObjectBehavior;

/**
 * Class StatusCodeSpec.
 *
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 * @mixin StatusCode
 */
class StatusCodeSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith(200);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Pact\Phpacto\Domain\Interaction\Communication\StatusCode');
    }

    public function it_should_return_value_it_was_created_with()
    {
        $this->jsonSerialize()->shouldReturn(200);
    }

    public function it_should_throw_exception_if_wrong_method_passed()
    {
        $this->shouldThrow(PactException::class)->during('__construct', ['']);
        $this->shouldThrow(PactException::class)->during('__construct', [null]);
        $this->shouldThrow(PactException::class)->during('__construct', ['NOT']);
        $this->shouldThrow(PactException::class)->during('__construct', ['aaa']);
        $this->shouldThrow(PactException::class)->during('__construct', [123]);
    }

    public function it_should_not_exception_for_correct_method_types()
    {
        $this->shouldNotThrow(PactException::class)->during('__construct', [StatusCode::OK_CODE]);
        $this->shouldNotThrow(PactException::class)->during('__construct', [StatusCode::NOT_FOUND_CODE]);
        $this->shouldNotThrow(PactException::class)->during('__construct', [204]);
    }
}
