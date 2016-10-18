<?php

namespace spec\Pact\Phpacto\Domain\Matching;

use Pact\Phpacto\Domain\Matching\Term;
use PhpSpec\ObjectBehavior;

/**
 * Class TermSpec.
 *
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 * @mixin Term
 */
class TermSpec extends ObjectBehavior
{
    /**
     * @var string
     */
    private $generate;
    /**
     * @var string
     */
    private $regex;

    public function let()
    {
        $this->generate = 'somethingToGenerate';
        $this->regex = '\\w+';
        $this->beConstructedWith($this->generate, $this->regex);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(\JsonSerializable::class);
    }

    public function it_should_return_term_as_ruby_object()
    {
        $this->jsonSerialize()->shouldReturn([
            'json_class' => 'Pact::Term',
            'data' => [
                'generate' => $this->generate,
                'matcher' => [
                    'json_class' => 'Regexp',
                    'o' => 0,
                    's' => $this->regex,
                ],
            ],
        ]);
    }
}
