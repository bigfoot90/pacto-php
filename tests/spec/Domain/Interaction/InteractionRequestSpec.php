<?php

namespace spec\Pact\Phpacto\Domain\Interaction;

use Pact\Phpacto\Domain\Interaction\Communication\Body;
use Pact\Phpacto\Domain\Interaction\Communication\Header;
use Pact\Phpacto\Domain\Interaction\Communication\Method;
use Pact\Phpacto\Domain\Interaction\Communication\Path;
use Pact\Phpacto\Domain\Interaction\Communication\Query;
use Pact\Phpacto\Domain\Interaction\InteractionRequest;
use PhpSpec\ObjectBehavior;

/**
 * Class InteractionRequestSpec.
 *
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 * @mixin InteractionRequest
 */
class InteractionRequestSpec extends ObjectBehavior
{
    public function let()
    {
        $method = new Method(Method::POST);
        $path = new Path('/client');
        $this->beConstructedWith($method, $path, new Body(), new Header(), new Query());
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(\JsonSerializable::class);
    }

    public function it_should_return_values_it_was_constructed_with()
    {
        \PHPUnit_Framework_Assert::assertEquals(json_encode([
            'method' => 'post',
            'path' => '/client',
        ]), json_encode($this->jsonSerialize()->getWrappedObject()));
    }

    public function it_should_be_constructable_with_more_parameters()
    {
        $this->beConstructedWith(
            $method = new Method(Method::POST),
            $path = new Path('/path'),
            $body = new Body(),
            $header = new Header(),
            $query = new Query()
        );

        \PHPUnit_Framework_Assert::assertEquals(json_encode([
            'method' => 'post',
            'path' => '/path',
        ]), json_encode($this->jsonSerialize()->getWrappedObject()));
    }
}
