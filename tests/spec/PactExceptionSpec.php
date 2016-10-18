<?php

namespace spec\Pact\Phpacto;

use PhpSpec\ObjectBehavior;

/**
 * Class PactExceptionSpec.
 *
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class PactExceptionSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(\Exception::class);
    }
}
