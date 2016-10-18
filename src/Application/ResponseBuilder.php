<?php

/**
 * @author Damian Dlugosz <d.dlugosz@bestnetwork.it>
 */

namespace Pact\Phpacto\Application;

use Pact\Phpacto\Domain\Interaction\Communication\Body;
use Pact\Phpacto\Domain\Interaction\Communication\Header;
use Pact\Phpacto\Domain\Interaction\Communication\StatusCode;
use Pact\Phpacto\Domain\Interaction\InteractionResponse;
use Pact\Phpacto\PactException;

class ResponseBuilder
{
    /**
     * @var ConsumerPactBuilder
     */
    private $pactBuilder;

    /**
     * @var StatusCode|null
     */
    private $statusCode;

    /**
     * @var Header|null
     */
    private $headers;

    /**
     * @var Body|null
     */
    private $body;

    /**
     * RequestBuilder constructor.
     *
     * @param ConsumerPactBuilder $pactBuilder
     */
    public function __construct(ConsumerPactBuilder $pactBuilder)
    {
        $this->pactBuilder = $pactBuilder;

        $this->statusCode(200);
    }

    /**
     * @param int $statusCode
     *
     * @return $this
     */
    public function statusCode($statusCode)
    {
        $this->statusCode = new StatusCode($statusCode);

        return $this;
    }

    /**
     * @param array $headers
     *
     * @return $this
     */
    public function headers($headers)
    {
        $this->headers = new Header($headers);

        return $this;
    }

    /**
     * @param array $body
     *
     * @return $this
     */
    public function body($body)
    {
        $this->body = new Body($body);

        return $this;
    }

    /**
     * @throws PactException
     *
     * @return InteractionResponse
     */
    public function build()
    {
        if (is_null($this->statusCode)) {
            throw new PactException('Response data need to have `status code`');
        }

        if (is_null($this->body)) {
            $this->body([]);
        }

        if (is_null($this->headers)) {
            $this->headers([]);
        }

        return new InteractionResponse(
            $this->statusCode,
            $this->body,
            $this->headers
        );
    }

    /**
     * @return ConsumerPactBuilder
     */
    public function end()
    {
        return $this->pactBuilder;
    }
}
