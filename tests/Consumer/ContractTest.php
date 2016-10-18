<?php

namespace Pact\Phpacto\Consumer;

use Pact\Phpacto\Pact;
use Zend\Diactoros\Request;
use Zend\Diactoros\Response;

class ContractTest extends \PHPUnit_Framework_TestCase
{
    public function testItShouldGetRequestResponse()
    {
        $request = new Request();
        $response = new Response();

        $c = new Pact($request, $response);

        self::assertEquals($request, $c->getRequest());
        self::assertEquals($response, $c->getResponse());
    }
}
