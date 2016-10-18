<?php

namespace spec\Pact\Phpacto\Domain\Interaction;

use Pact\Phpacto\Domain\Interaction\Communication\Body;
use Pact\Phpacto\Domain\Interaction\Communication\Header;
use Pact\Phpacto\Domain\Interaction\Communication\StatusCode;
use Pact\Phpacto\Domain\Interaction\InteractionResponse;
use PhpSpec\ObjectBehavior;

/**
 * Class InteractionResponseSpec.
 *
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 * @mixin InteractionResponse
 */
class InteractionResponseSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith(new StatusCode(StatusCode::OK_CODE));
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(\JsonSerializable::class);
    }

    public function it_should_return_values_it_was_constructed_with()
    {
        \PHPUnit_Framework_Assert::assertEquals(json_encode([
            'status' => 200,
        ]), json_encode($this->jsonSerialize()->getWrappedObject()));
    }

    public function it_should_be_constructed_with_more_parameters()
    {
        $this->beConstructedWith(
            $statusCode = new StatusCode(StatusCode::OK_CODE),
            $body = new Body(),
            $header = new Header()
        );

        \PHPUnit_Framework_Assert::assertEquals(json_encode([
            'status' => 200,
        ]), json_encode($this->jsonSerialize()->getWrappedObject()));
    }
}
