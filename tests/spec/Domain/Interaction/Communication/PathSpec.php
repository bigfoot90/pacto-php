<?php

namespace spec\Pact\Phpacto\Domain\Interaction\Communication;

use Pact\Phpacto\Domain\Interaction\Communication\Path;
use Pact\Phpacto\PactException;
use PhpSpec\ObjectBehavior;

/**
 * Class PathSpec.
 *
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 * @mixin Path
 */
class PathSpec extends ObjectBehavior
{
    private $path;

    public function let()
    {
        $this->path = '/path/to/some';
        $this->beConstructedWith($this->path);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Pact\Phpacto\Domain\Interaction\Communication\Path');
    }

    public function it_should_return_path()
    {
        $this->jsonSerialize()->shouldReturn($this->path);
    }

    public function it_should_throw_exception_if_wrong_path_passed()
    {
        $this->shouldThrow(PactException::class)->during('__construct', [null]);
        $this->shouldThrow(PactException::class)->during('__construct', ['']);
        $this->shouldThrow(PactException::class)->during('__construct', ['bla']);
        $this->shouldThrow(PactException::class)->during('__construct', ['bla/']);
        $this->shouldThrow(PactException::class)->during('__construct', ['bl/a']);
        $this->shouldThrow(PactException::class)->during('__construct', [123]);
        $this->shouldThrow(PactException::class)->during('__construct', ['/']);
    }

    public function it_should_not_throw_for_correct_path()
    {
        $this->shouldNotThrow(PactException::class)->during('__construct', ['/resource']);
        $this->shouldNotThrow(PactException::class)->during('__construct', ['/resource/1']);
        $this->shouldNotThrow(PactException::class)->during('__construct', ['/resource/1/resource']);
        $this->shouldNotThrow(PactException::class)->during('__construct', ['/resource/1/resource/30']);
        $this->shouldNotThrow(PactException::class)->during('__construct', ['/resource/1/resource/30/test']);
    }
}
