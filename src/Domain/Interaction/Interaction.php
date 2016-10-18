<?php

namespace Pact\Phpacto\Domain\Interaction;

/**
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class Interaction implements \JsonSerializable
{
    /**
     * @var ProviderState
     */
    private $providerState;
    /**
     * @var Description
     */
    private $description;
    /**
     * @var InteractionRequest
     */
    private $interactionRequest;
    /**
     * @var InteractionResponse
     */
    private $interactionResponse;

    /**
     * @param ProviderState       $providerState
     * @param Description         $description
     * @param InteractionRequest  $interactionRequest
     * @param InteractionResponse $interactionResponse
     */
    public function __construct(ProviderState $providerState, Description $description, InteractionRequest $interactionRequest, InteractionResponse $interactionResponse)
    {
        $this->providerState = $providerState;
        $this->description = $description;
        $this->interactionRequest = $interactionRequest;
        $this->interactionResponse = $interactionResponse;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        $interaction = [
            'description' => $this->description,
        ];

        $interaction['provider_state'] = $this->providerState;
        $interaction['request'] = $this->interactionRequest;
        $interaction['response'] = $this->interactionResponse;

        return $interaction;
    }
}
