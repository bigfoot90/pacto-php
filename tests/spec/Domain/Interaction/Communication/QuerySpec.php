<?php

namespace spec\Pact\Phpacto\Domain\Interaction\Communication;

use Pact\Phpacto\Domain\Interaction\Communication\Query;
use Pact\Phpacto\PactException;
use PhpSpec\ObjectBehavior;

/**
 * Class QuerySpec.
 *
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 * @mixin Query
 */
class QuerySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Pact\Phpacto\Domain\Interaction\Communication\Query');
    }

    public function it_should_return_empty_jsonSerialize()
    {
        $this->jsonSerialize()->shouldReturn([]);
    }

    public function it_should_add_key_value()
    {
        $this->beConstructedWith([
            'name' => ['Franek'],
        ]);

        $this->jsonSerialize()->shouldReturn([
            'name' => ['Franek'],
        ]);
    }

    public function it_should_add_multiple_key_values()
    {
        $this->beConstructedWith([
            'name' => 'Franek',
            'surname' => 'Edwin',
        ]);

        $this->jsonSerialize()->shouldReturn([
            'name' => 'Franek',
            'surname' => 'Edwin',
        ]);
    }

    public function it_should_return_multiple_values_if_under_same_key()
    {
        $this->beConstructedWith([
            'name' => ['John', 'Edward'],
        ]);

        $this->jsonSerialize()->shouldReturn([
            'name' => ['John', 'Edward'],
        ]);
    }

    public function it_should_handle_query_as_string()
    {
        $this->beConstructedWith('name=Mary+jane&age=8');

        $this->jsonSerialize()->shouldReturn('name=Mary+jane&age=8');
    }

    public function it_should_throw_exception_if_empty_key_or_value_passed()
    {
        $this->shouldThrow(PactException::class)->during('__construct', [['name' => '']]);
        $this->shouldThrow(PactException::class)->during('__construct', [['' => 'some']]);
        $this->shouldThrow(PactException::class)->during('__construct', [['' => '']]);
    }
}
