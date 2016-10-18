<?php

namespace Pact\Phpacto\Domain\Interaction;

use Pact\Phpacto\PactException;

/**
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class InteractionFactory
{
    /**
     * @param string              $providerState
     * @param string              $description
     * @param InteractionRequest  $interactionRequest
     * @param InteractionResponse $interactionResponse
     *
     * @throws PactException
     *
     * @return Interaction
     */
    public function create($providerState, $description, InteractionRequest $interactionRequest, InteractionResponse $interactionResponse)
    {
        return new Interaction(
            new ProviderState($providerState),
            new Description($description),
            $interactionRequest,
            $interactionResponse
        );
    }
}
