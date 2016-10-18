<?php

/**
 * @author Damian Dlugosz <d.dlugosz@bestnetwork.it>
 */

namespace Pact\Phpacto\Application;

use Pact\Phpacto\Domain\Interaction\Communication\Body;
use Pact\Phpacto\Domain\Interaction\Communication\Header;
use Pact\Phpacto\Domain\Interaction\Communication\Method;
use Pact\Phpacto\Domain\Interaction\Communication\Path;
use Pact\Phpacto\Domain\Interaction\Communication\Query;
use Pact\Phpacto\Domain\Interaction\InteractionRequest;
use Pact\Phpacto\PactException;

class RequestBuilder
{
    /**
     * @var ConsumerPactBuilder
     */
    private $pactBuilder;

    /**
     * @var Method|null
     */
    private $method;

    /**
     * @var Path|null
     */
    private $path;

    /**
     * @var Query|null
     */
    private $query;

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

        $this->method('get');
    }

    /**
     * @param string $method
     *
     * @return $this
     */
    public function method($method)
    {
        $this->method = new Method($method);

        return $this;
    }

    /**
     * @param string $path
     *
     * @return $this
     */
    public function path($path)
    {
        $this->path = new Path($path);

        return $this;
    }

    /**
     * @param array $query
     *
     * @return $this
     */
    public function query($query)
    {
        $this->query = new Query($query);

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
     * @return InteractionRequest
     */
    public function build()
    {
        if (is_null($this->method)) {
            throw new PactException('Request data need to have `method`');
        }

        if (is_null($this->path)) {
            throw new PactException('Request data need to have `path`');
        }

        if (is_null($this->body)) {
            $this->body([]);
        }

        if (is_null($this->headers)) {
            $this->headers([]);
        }

        if (is_null($this->query)) {
            $this->query([]);
        }

        return new InteractionRequest(
            $this->method,
            $this->path,
            $this->body,
            $this->headers,
            $this->query
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
