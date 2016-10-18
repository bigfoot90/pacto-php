<?php

namespace Pact\Phpacto\Domain\Interaction;

use Pact\Phpacto\Domain\Interaction\Communication\Body;
use Pact\Phpacto\Domain\Interaction\Communication\Header;
use Pact\Phpacto\Domain\Interaction\Communication\Method;
use Pact\Phpacto\Domain\Interaction\Communication\Path;
use Pact\Phpacto\Domain\Interaction\Communication\Query;

/**
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class InteractionRequest implements \JsonSerializable
{
    /**
     * @var Method
     */
    private $method;

    /**
     * @var Path
     */
    private $path;

    /**
     * @var Body
     */
    private $body;

    /**
     * @var Header
     */
    private $header;

    /**
     * @var Query
     */
    private $query;

    /**
     * InteractionRequest constructor.
     *
     * @param Method $method
     * @param Path   $path
     * @param Body   $body
     * @param Header $header
     * @param Query  $query
     */
    public function __construct(Method $method, Path $path, Body $body = null, Header $header = null, Query $query = null)
    {
        $this->method = $method;
        $this->path = $path;
        $this->body = $body ?: new Body();
        $this->header = $header ?: new Body();
        $this->query = $query ?: new Body();
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        $serializedJson = [
            'method' => $this->method,
            'path' => $this->path,
        ];

        if (!$this->query->isEmpty()) {
            $serializedJson['query'] = $this->query;
        }

        if (!$this->header->isEmpty()) {
            $serializedJson['headers'] = $this->header;
        }

        if (!$this->body->isEmpty()) {
            $serializedJson['body'] = $this->body;
        }

        return $serializedJson;
    }
}
