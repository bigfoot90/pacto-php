<?php

/**
 * @author Damian Dlugosz <d.dlugosz@bestnetwork.it>
 */

namespace Pact\Phpacto\Domain\Interaction\Communication;

use Pact\Phpacto\PactException;

class KeyValueCollection implements \JsonSerializable
{
    /** @var  array|string[]|int[]|\JsonSerializable[] */
    private $data = [];

    /**
     * Body constructor.
     *
     * @param string|array|object $data
     */
    public function __construct($data = [])
    {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $this->setSingleData($key, $value);
            }
        } else {
            $this->data = $data;
        }
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->data);
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->data;
    }

    /**
     * @param string $key
     * @param string $value
     *
     * @throws PactException
     */
    private function setSingleData($key, $value)
    {
        if (!$key || !$value) {
            throw new PactException("Key and values should'nt be empty");
        }

        if (is_object($value) && !($value instanceof \JsonSerializable || method_exists($value, '__toString'))) {
            throw new PactException('Value must implement \JsonSerializable or have `__toString` method');
        }

        $this->data[$key] = $value;
    }
}
