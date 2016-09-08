<?php

use Pact\Phpacto\Builder\PactBuilder;
use Pact\Phpacto\Builder\PactInteraction;

/**
 * Class PactoPactBuilderTest
 * @package Pact\Phpacto\Test
 */
class PactoPactBuilderTest extends \PHPUnit_Framework_TestCase
{

    public function setup()
    {
    }

    public function testCanSetProviderName()
    {
        $providerName = "Some name";
        $pb = new PactBuilder();
        $pb->HasPactWith($providerName);

        $this->assertEquals($pb->ProviderName(), $providerName, "The provider name was not set properly");
    }

    public function testCanSetConsumerName()
    {
        $consumerName = "Some name";
        $pb = new PactBuilder();
        $pb->ServiceConsumer($consumerName);

        $this->assertEquals($pb->ConsumerName(), $consumerName, "The provider name was not set properly");
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testConsumerNameCannotBeEmpty()
    {
        $consumerName = "";
        $pb = new PactBuilder();
        $pb->ServiceConsumer($consumerName);
    }


    /**
     * @expectedException InvalidArgumentException
     */
    public function testProviderNameCannotBeEmpty()
    {
        $providerName = "";
        $pb = new PactBuilder();
        $pb->HasPactWith($providerName);
    }


    public function testCanAddMetadata()
    {
        $metadata = array("key1" => "value1");
        $pb = new PactBuilder();
        $pb->AddMetadata($metadata);

        $this->assertEquals($metadata, $pb->Metadata());
    }

    public function testCanAppendMetadataOriginalValuesPersist()
    {
        $metadata1 = array("key1" => "value1");
        $pb = new PactBuilder();
        $pb->AddMetadata($metadata1);

        $this->assertArrayHasKey("key1", $pb->Metadata());

        $metadata2 = array("key2" => "value2");
        $pb->AddMetadata($metadata2);

        $this->assertArrayHasKey("key1", $pb->Metadata());
        $this->assertArrayHasKey("key2", $pb->Metadata());
        $this->assertCount(2, array_count_values($pb->Metadata()));
    }

    public function testCanBuildJsonContractAndWriteToFile()
    {
        $filename = __DIR__ . "/test-pack.json";

        // Build the contract
        $pb = new PactBuilder();
        $pactJson = $pb->ServiceConsumer("blah")
                ->HasPactWith("someProvider")
                ->AddMetadata(array("pact-specification" => array("version" => "2.0.0")))
                ->Build($filename);

        // persist to file
        file_put_contents($filename, $pactJson);
        $this->assertTrue(file_exists($filename));

        // whatever is written shall BE!
        $newFile = file_get_contents($filename);
        $this->assertEquals($pactJson, $newFile);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testPactInteractionRequestMethodMustBeString()
    {
        $pi = (new PactInteraction())
                ->Description("Some description")
                ->ProviderState("Get an user with ID 239443")
                ->RequestMethod(200)
                ->RequestPath("/some/path");
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testPactInteractionRequestMethodCannotBeEmptyString()
    {
        $pi = (new PactInteraction())
                ->Description("Some description")
                ->ProviderState("Get an user with ID 239443")
                ->RequestMethod("")
                ->RequestPath("/some/path");
    }

    public function testPactInteractionRequestHeaderMustBeArray()
    {
        $headers = array("Content-Type" => "application/json");

        $pi = (new PactInteraction())
                ->Description("Some description")
                ->ProviderState("Get an user with ID 239443")
                ->RequestMethod("GET")
                ->RequestHeaders($headers)
                ->RequestPath("/some/path");

        $this->assertEquals($headers, $pi->Headers());
    }

    public function InteractionHeaderCases()
    {
        return array(
                array(""),
                array("hello"),
                array(200)
        );
    }

    /**
     * @expectedException InvalidArgumentException
     * @dataProvider InteractionHeaderCases
     * @param $headers array HTTP message headers
     */
    public function testPactInteractionRequestHeaderThrowsErrorWhenNotArray($headers)
    {
        $pi = (new PactInteraction())
                ->Description("Some description")
                ->ProviderState("Get an user with ID 239443")
                ->RequestMethod("GET")
                ->RequestHeaders($headers)
                ->RequestPath("/some/path");
    }


}
