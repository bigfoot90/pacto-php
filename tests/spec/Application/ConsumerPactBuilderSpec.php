<?php

namespace spec\Pact\Phpacto\Application;

use Pact\Phpacto\Application\ConsumerPactBuilder;
use Pact\Phpacto\Application\Pact;
use Pact\Phpacto\Domain\Interaction\Interaction;
use Pact\Phpacto\Domain\Interaction\InteractionFactory;
use Pact\Phpacto\PactException;
use PhpSpec\ObjectBehavior;

/**
 * Class ConsumerPactBuilderSpec.
 *
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 * @mixin ConsumerPactBuilder
 */
class ConsumerPactBuilderSpec extends ObjectBehavior
{
    /** @var  InteractionFactory */
    private $interactionFactory;

    public function let(InteractionFactory $interactionFactory)
    {
        $this->interactionFactory = $interactionFactory;

        $this->beConstructedWith('', '');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Pact\Phpacto\Application\ConsumerPactBuilder');
    }

    public function it_should_set_provider_state(Interaction $interaction)
    {
        $consumerPactBuilder = $this
            ->given('An alligator named Mary exists')
            ->action('A request for an alligator')
            ->withRequest('get', '/alligators/Mary')
                ->query([
                    'name' => 'Fred',
                ])
                ->headers([
                    'Accept' => 'application/json',
                ])
                ->body([
                    'param' => 1,
                ])
            ->end()
            ->willRespondWith(200)
                ->headers([
                    'Content-Type' => 'application/json',
                ])
                ->body([
                    'name' => 'Mary',
                    'children' => Pact::eachLike(['name' => 'Fred', 'age' => 2]),
                ])
            ->end();

        $interaction = $consumerPactBuilder->build();

        $interaction->shouldHaveType(Interaction::class);
    }

    public function it_should_throw_exception_if_setting_up_not_finished_pact()
    {
        $this->shouldThrow(PactException::class)->during('build');
    }

    public function it_should_throw_exception_if_setting_up_not_finished_pact_with_only_given()
    {
        $this->given('An alligator named Mary exists');

        $this->shouldThrow(PactException::class)->during('build');
    }

    public function it_should_throw_exception_if_setting_up_no_finished_pact_with_given_and_receiving()
    {
        $this
            ->given('An alligator named Mary exists')
            ->action('Request for alligator');

        $this->shouldThrow(PactException::class)->during('build');
    }

    public function it_should_throw_exception_if_setting_up_no_finished_pact_without_request()
    {
        $this
            ->given('An alligator named Mary exists')
            ->action('Request for alligator')
            ->willRespondWith(200);

        $this->shouldThrow(PactException::class)->during('build');
    }
}
