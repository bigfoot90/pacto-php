<?php

namespace Pact\Phpacto\Domain\Interaction;

use Pact\Phpacto\PactException;

/**
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
class Description implements \JsonSerializable
{
    /** @var  string */
    private $value;

    /**
     * @param string $value
     *
     * @throws PactException
     */
    public function __construct($value)
    {
        if (!is_string($value)) {
            throw new PactException('descriction must be a string');
        }

        if (empty($value)) {
            throw new PactException('Can\'t create empty description');
        }

        $this->value = $value;
    }

    /**
     * @return string
     */
    public function jsonSerialize()
    {
        return $this->value;
    }
}
