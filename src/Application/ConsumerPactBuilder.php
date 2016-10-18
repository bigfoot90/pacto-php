<?php

namespace Pact\Phpacto\Application;

use Pact\Phpacto\Domain\Interaction\InteractionFactory;
use Pact\Phpacto\PactException;

/**
 * Class ConsumerPactBuilder
 * Usage:
 *  ->given
 *  ->action
 *  ->withRequest
 *  ->willRespondWith.
 *
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
final class ConsumerPactBuilder
{
    /**
     * @var string
     */
    private $given = '';

    /**
     * @var string
     */
    private $action = '';

    /**
     * @var RequestBuilder
     */
    private $requestBuilder;

    /**
     * @var ResponseBuilder
     */
    private $responseBuilder;

    /**
     * ConsumerPactBuilder constructor.
     */
    public function __construct()
    {
        $this->requestBuilder = new RequestBuilder($this);
        $this->responseBuilder = new ResponseBuilder($this);
    }

    /**
     * Provider state while sending a request.
     * For example ("An alligator named Mary exists").
     *
     * @param string $providerState
     *
     * @return $this
     */
    public function given($providerState)
    {
        $this->given = $providerState;

        return $this;
    }

    /**
     * Action information for example ("A request for an alligator").
     *
     * @param string $action
     *
     * @return $this
     */
    public function action($action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Request data, which will be send to the consumer.
     *
     * Example:
     *  withRequest('get', '/alligators/Mary')
     *      ->query([
     *          'name' => 'Fred'
     *      ])
     *      ->headers([
     *          'Accept' => 'application/json'
     *      ])
     *      ->body([
     *          'param' => 1
     *      ])
     *  ->end();
     *
     * @param string $method
     * @param string $path
     *
     * @return RequestBuilder
     */
    public function withRequest($method, $path)
    {
        $this->requestBuilder->method($method);
        $this->requestBuilder->path($path);

        return $this->requestBuilder;
    }

    /**
     * Response data, which should be be received from provider after doing request.
     *
     * Example:
     *  willRespondWith(200)
     *      ->headers([
     *          'Content-Type' => 'application/json'
     *      ])
     *      ->body([
     *          'name' => 'Mary'
     *      ])
     *  ->end();
     *
     * @param int $statusCode
     *
     * @return ResponseBuilder
     */
    public function willRespondWith($statusCode)
    {
        $this->responseBuilder->statusCode($statusCode);

        return $this->responseBuilder;
    }

    /**
     * @return InteractionFactory
     */
    protected function getInteractionFactory()
    {
        return new InteractionFactory();
    }

    /**
     * Provides interaction based on passed configuration.
     *
     * @throws PactException
     *
     * @return \Pact\Phpacto\Domain\Interaction\Interaction
     */
    public function build()
    {
        if (empty($this->given)) {
            throw new PactException('Before setting up, you need to set given');
        }

        if (empty($this->action)) {
            throw new PactException('Before setting up, you need to set action');
        }

        $interactionRequest = $this->requestBuilder->build();
        $interactionResponse = $this->responseBuilder->build();

        return $this->getInteractionFactory()->create($this->given, $this->action, $interactionRequest, $interactionResponse);
    }
}
