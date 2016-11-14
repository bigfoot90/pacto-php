<?php

namespace Pact\Phpacto\Test;

use Pact\Phpacto\Service\PactProviderService;

define('DEFAULT_CONSUMER_CONTRACTS', __DIR__.'/consumer-contracts');

/**
 * Class PactoPactProviderServiceTest.
 */
class PactoPactProviderServiceTest extends \PHPUnit_Framework_TestCase
{
    private static $providerService;
    private $svc;

    /**
     * @beforeClass
     */
    public static function setUpTestFixture()
    {
        if (is_null(self::$providerService)) {
            self::$providerService = new PactProviderService(DEFAULT_CONSUMER_CONTRACTS);
            self::$providerService->ServiceConsumer('consumer')->HasPactWith('provider');
        }
    }

    /**
     * @afterClass
     */
    public static function tearDownTestFixture()
    {
        self::$providerService->WriteContract();
    }

    public function setUp()
    {
        if (!is_null(self::$providerService)) {
            $this->svc = self::$providerService;
        }
    }

    public function tearDown()
    {
        $this->svc->Stop();
    }

    public function testPactoProviderService()
    {
        $expectedResponse = [
                'status' => 200,
                'headers' => ['Content-Type' => 'application/json;charset=utf-8'],
                'body' => ['name' => 'Mary'],
        ];

        // Arrange
        $this->svc
                ->Given('some provider state')
                ->UponReceiving('some description of the interaction')
                ->With(
                        [
                                'method' => 'get',
                                'path' => '/some/path',
                                'headers' => ['Accept' => 'application/json'],
                        ]
                )
                ->WillRespond($expectedResponse);

        // Act
        $actualResponse = $this->svc->Start();

        // Assert
        $actualResponseBody = json_decode((string) $actualResponse->getBody(), true);
        self::assertEquals($expectedResponse['body'], $actualResponseBody);
        self::assertEquals($expectedResponse['status'], $actualResponse->getStatus());
        self::assertEquals($expectedResponse['headers'], $actualResponse->headers()->all());
    }

    public function testAllowCustomResponseToHaveNoHeaderWhenReturned()
    {

        // Arrange
        $this->svc
                ->Given('some provider state')
                ->UponReceiving('some description of the interaction')
                ->With(
                        [
                            'method' => 'get',
                            'path' => '/some/path',
                        ]
                )
                ->WillRespond(
                        [
                            'status' => 200,
                            'body' => 'The quick brown fox...',
                        ]
                );

        // Act
        $actualResponse = $this->svc->Start();

        // Assert
        self::assertEquals($actualResponse->headers()->all(), []);
    }

    public function testAllowCustomResponseToHaveNoBodyWhenReturned()
    {

            // Arrange
            $this->svc
                    ->Given('some provider state')
                    ->UponReceiving('some description of the interaction')
                    ->With(
                            [
                                'method' => 'get',
                                'path' => '/some/path',
                            ]
                    )
                    ->WillRespond(
                            [
                                'status' => 200,
                            ]
                    );

            // Act
            $actualResponse = $this->svc->Start();

            // Assert
            self::assertEquals($actualResponse->getBody(), '');
    }
}
