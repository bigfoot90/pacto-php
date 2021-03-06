<?php

namespace Pact\Phpacto\Service;

use Pact\Phpacto\Builder\PactBuilder;
use Pact\Phpacto\Builder\PactInteraction;
use Pact\Phpacto\Config\Constants;
use Slim\Environment;

/**
 * Mock Service that implements a local web server to which calls can be directed.
 */
class PactProviderService
{
    private $contractFolder;
    private $uri;
    private $pactBuilder;
    private $interaction;

    public function __construct($contractFolder, $uri = 'http://127.0.0.1:8880')
    {
        $this->contractFolder = $contractFolder;
        $this->uri = $uri;

        $this->pactBuilder = new PactBuilder();
        $this->pactBuilder->AddMetadata(
                [
                        'pact-specification' => ['version' => Constants::PACT_SPEC_VERSION],
                        'pact-php' => ['version' => Constants::PACTO_PHP_VERSION],
                ]
        );
    }

    public function ServiceConsumer($consumerName)
    {
        $this->pactBuilder->ServiceConsumer($consumerName);

        return $this;
    }

    public function HasPactWith($providerName)
    {
        $this->pactBuilder->HasPactWith($providerName);

        return $this;
    }

    public function Uri()
    {
        return $this->uri;
    }

    public function ContractFolder()
    {
        return $this->contractFolder;
    }

    public function Given($providerState)
    {
        if (is_null($this->interaction)) {
            $this->interaction = new PactInteraction();
        }

        $this->interaction->ProviderState($providerState);

        return $this;
    }

    public function With(array $request)
    {
        $this->interaction->SetRequest($request);

        return $this;
    }

    public function UponReceiving($description)
    {
        $this->interaction->Description($description);

        return $this;
    }

    public function WillRespond(array $response)
    {
        $this->interaction->SetResponse($response);
        $this->pactBuilder->AddInteraction($this->interaction);
    }

    /**
     * @return \Slim\Http\Response
     */
    public function Start()
    {
        // create the app with the appropriate route
        $app = new MockProvider();

        $int = $this->interaction;
        $app->map(
                $int->Path(),
                function () use ($int, $app) {
                    if (array_key_exists('headers', $int->Response())) {
                        $app->response->headers->replace($int->Headers(RESPONSE));
                    } else {
                        $app->response->headers->clear();
                    }

                    if (array_key_exists('body', $int->Response())) {
                        echo json_encode($int->Body(RESPONSE));
                    }
                }

        )->via('GET', 'POST', 'PUT', 'DELETE', 'OPTIONS');

        Environment::mock(
                [
                        'PATH_INFO' => $this->interaction->Path(),
                        'HTTP_USER_AGENT' => sprintf('Pacto-Php %s', Constants::PACTO_PHP_VERSION),
                        'USER_AGENT' => sprintf('Pacto-Php %s', Constants::PACTO_PHP_VERSION),
                ]
        );

        $response = $app->invoke();

        return $response;
    }

    public function Stop()
    {
        // reset the interaction
        $this->interaction = null;
    }

    public function WriteContract($filename = 'consumer-provider.json')
    {
        $pact = $this->pactBuilder->Build();

        $filename = !is_null($this->pactBuilder) ? sprintf(
                '%s/%s-%s.json',
                $this->contractFolder,
                $this->pactBuilder->ConsumerName(),
                $this->pactBuilder->ProviderName()
        ) : $filename;

        if (!is_dir($this->contractFolder)) {
            mkdir($this->contractFolder, 0777, true);
        }

        file_put_contents($filename, $pact);
    }
}
