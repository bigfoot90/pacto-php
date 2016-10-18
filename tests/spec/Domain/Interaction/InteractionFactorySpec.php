<?php

namespace spec\Pact\Phpacto\Domain\Interaction;

use Pact\Phpacto\Domain\Interaction\Interaction;
use Pact\Phpacto\Domain\Interaction\InteractionFactory;
use Pact\Phpacto\Domain\Interaction\InteractionRequest;
use Pact\Phpacto\Domain\Interaction\InteractionResponse;
use PhpSpec\ObjectBehavior;

/**
 * Class InteractionFactorySpec.
 *
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 * @mixin InteractionFactory
 */
class InteractionFactorySpec extends ObjectBehavior
{
    private $interactionRequest;
    private $interactionResponse;

    public function let(InteractionRequest $interactionRequest, InteractionResponse $interactionResponse)
    {
        $this->interactionRequest = $interactionRequest;
        $this->interactionResponse = $interactionResponse;

        $this->interactionRequest->jsonSerialize()->willReturn([
            'method' => 'get',
            'path' => '/client',
        ]);

        $this->interactionResponse->jsonSerialize()->willReturn([
            'status' => 200,
        ]);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Pact\Phpacto\Domain\Interaction\InteractionFactory');
    }

    public function it_should_create_interaction_object()
    {
        $interaction = $this->create('provider info', 'request info', $this->interactionRequest, $this->interactionResponse);

        $interaction->shouldHaveType(Interaction::class);

        \PHPUnit_Framework_Assert::assertEquals(json_encode([
            'description' => 'request info',
            'provider_state' => 'provider info',
            'request' => [
                'method' => 'get',
                'path' => '/client',
            ],
            'response' => [
                'status' => 200,
            ],
        ]), json_encode($interaction->getWrappedObject()));
    }
}
