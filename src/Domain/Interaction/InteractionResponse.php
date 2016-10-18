<?php

namespace Pact\Phpacto\Domain\Interaction;

use Pact\Phpacto\Domain\Interaction\Communication\Body;
use Pact\Phpacto\Domain\Interaction\Communication\Header;
use Pact\Phpacto\Domain\Interaction\Communication\StatusCode;

/**
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class InteractionResponse implements \JsonSerializable
{
    /**
     * @var StatusCode
     */
    private $statusCode;
    /**
     * @var Body
     */
    private $body;
    /**
     * @var Header
     */
    private $header;

    /**
     * @param StatusCode  $statusCode
     * @param Body|null   $body
     * @param Header|null $header
     */
    public function __construct(StatusCode $statusCode, Body $body = null, Header $header = null)
    {
        $this->statusCode = $statusCode;
        $this->body = $body ?: new Body();
        $this->header = $header ?: new Header();
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        $serializedJson = [
            'status' => $this->statusCode,
        ];

        if (!$this->header->isEmpty()) {
            $serializedJson['headers'] = $this->header;
        }

        if (!$this->body->isEmpty()) {
            $serializedJson['body'] = $this->body;
        }

        return $serializedJson;
    }
}
