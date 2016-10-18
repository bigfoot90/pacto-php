<?php

namespace Pact\Phpacto\Domain\Interaction\Communication;

use Pact\Phpacto\PactException;

/**
 * Class Method.
 *
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class Method implements \JsonSerializable
{
    const GET = 'get';
    const POST = 'post';
    const PUT = 'put';
    const DELETE = 'delete';
    const PATCH = 'patch';

    /**
     * @var string
     */
    private $type;

    /**
     * Method constructor.
     *
     * @param string $methodType
     */
    public function __construct($methodType)
    {
        $this->setType($methodType);
    }

    /**
     * @return string
     */
    public function jsonSerialize()
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @throws PactException
     */
    private function setType($type)
    {
        $type = strtolower($type);

        $selfRfl = new \ReflectionClass($this);
        $constants = $selfRfl->getConstants();

        if (!in_array($type, $constants)) {
            throw new PactException('Passed Method type '.$type." doesn't exists.");
        }

        $this->type = $type;
    }
}
