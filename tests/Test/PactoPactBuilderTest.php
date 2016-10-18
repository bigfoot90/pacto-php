<?php

namespace Pact\Phpacto\Test;

use Pact\Phpacto\Builder\PactBuilder;
use Pact\Phpacto\Builder\PactInteraction;

/**
 * Class PactoPactBuilderTest.
 */
class PactoPactBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testCanSetProviderName()
    {
        $providerName = 'Some name';
        $pb = new PactBuilder();
        $pb->HasPactWith($providerName);

        self::assertEquals($pb->ProviderName(), $providerName, 'The provider name was not set properly');
    }

    public function testCanSetConsumerName()
    {
        $consumerName = 'Some name';
        $pb = new PactBuilder();
        $pb->ServiceConsumer($consumerName);

        self::assertEquals($pb->ConsumerName(), $consumerName, 'The provider name was not set properly');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConsumerNameCannotBeEmpty()
    {
        $consumerName = '';
        $pb = new PactBuilder();
        $pb->ServiceConsumer($consumerName);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testProviderNameCannotBeEmpty()
    {
        $providerName = '';
        $pb = new PactBuilder();
        $pb->HasPactWith($providerName);
    }

    public function testCanAddMetadata()
    {
        $metadata = ['key1' => 'value1'];
        $pb = new PactBuilder();
        $pb->AddMetadata($metadata);

        self::assertEquals($metadata, $pb->Metadata());
    }

    public function testCanAddRemoveMetadata()
    {
        $metadata = ['key1' => 'value1'];
        $pb = new PactBuilder();
        $pb->AddMetadata($metadata);
        self::assertEquals($metadata, $pb->Metadata());

        $pb->AddMetadata(['key2' => 'value2']);
        self::assertNotEquals($metadata, $pb->Metadata());

        $pb->RemoveMetadata('key2');
        self::assertEquals($metadata, $pb->Metadata());
    }

    public function testCanAppendMetadataOriginalValuesPersist()
    {
        $metadata1 = ['key1' => 'value1'];
        $pb = new PactBuilder();
        $pb->AddMetadata($metadata1);

        self::assertArrayHasKey('key1', $pb->Metadata());

        $metadata2 = ['key2' => 'value2'];
        $pb->AddMetadata($metadata2);

        self::assertArrayHasKey('key1', $pb->Metadata());
        self::assertArrayHasKey('key2', $pb->Metadata());
        self::assertCount(2, array_count_values($pb->Metadata()));
    }

    public function testCanBuildJsonContractAndWriteToFile()
    {
        $filename = __DIR__.'/test-pact.json';

        $pi = (new PactInteraction())
                ->Description('Some description')
                ->ProviderState('Get an user with ID 239443')
                ->RequestMethod('GET')
                ->RequestHeaders(['Content-Type' => 'application/json'])
                ->RequestPath('/some/path')
                ->ResponseHeaders(['Content-Type' => 'application/json'])
                ->ResponseStatus(400)
                ->ResponseBody('Some message');

        // Build the contract
        $pb = new PactBuilder();
        $pactJson = $pb->ServiceConsumer('blah')
                ->HasPactWith('someProvider')
                ->AddMetadata(['pact-specification' => ['version' => '2.0.0']])
                ->AddInteraction($pi)
                ->Build();

        // persist to file
        file_put_contents($filename, $pactJson);
        self::assertStringEqualsFile($filename, $pactJson);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testPactInteractionRequestMethodMustBeString()
    {
        $pi = (new PactInteraction())
                ->Description('Some description')
                ->ProviderState('Get an user with ID 239443')
                ->RequestMethod(200)
                ->RequestPath('/some/path');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testPactInteractionRequestMethodCannotBeEmptyString()
    {
        $pi = (new PactInteraction())
                ->Description('Some description')
                ->ProviderState('Get an user with ID 239443')
                ->RequestMethod('')
                ->RequestPath('/some/path');
    }

    public function testPactInteractionRequestHeaderMustBeArray()
    {
        $headers = ['Content-Type' => 'application/json'];

        $pi = (new PactInteraction())
                ->RequestHeaders($headers);

        self::assertEquals($headers, $pi->Headers(REQUEST));
    }

    public function InteractionHeaderCases()
    {
        return [
            [''],
            ['hello'],
            [200],
        ];
    }

    /**
     * @expectedException \InvalidArgumentException
     * @dataProvider InteractionHeaderCases
     *
     * @param $headers array HTTP message headers
     */
    public function testPactInteractionRequestHeaderThrowsErrorWhenNotArray($headers)
    {
        (new PactInteraction())->RequestHeaders($headers);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @dataProvider InteractionHeaderCases
     *
     * @param $headers array HTTP message headers
     */
    public function testPactInteractionResponseHeaderThrowsErrorWhenNotArray($headers)
    {
        (new PactInteraction())->ResponseHeaders($headers);
    }
}
