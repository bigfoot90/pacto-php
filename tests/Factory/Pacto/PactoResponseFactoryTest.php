<?php

namespace Pact\Phpacto\Factory\Pacto;

use Pact\Phpacto\Fixture;

class PactoResponseFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testItShouldReturnsAPsr7Response()
    {
        $factoryRequest = new PactoResponseFactory();

        $response = $factoryRequest->from($this->getResponseArray());

        self::assertEquals('{"error":"Argh!!!"}', $response->getBody());
        self::assertEquals(500, $response->getStatusCode());
        self::assertEquals(['Content-Type' => ['application/json;charset=utf-8']], $response->getHeaders());
    }

    private function getResponseArray()
    {
        $content = json_decode(Fixture::load('hello_world.json'), true);

        return $content['interactions'][0]['response'];
    }
}
