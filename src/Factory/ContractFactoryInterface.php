<?php

namespace Pact\Phpacto\Factory;

use Pact\Phpacto\Pact;

interface ContractFactoryInterface
{
    /**
     * @param $jsonDescription
     *
     * @return Pact
     */
    public function from($jsonDescription);
}
