<?php

namespace Pact\Phpacto\Test\Output;

use Pact\Phpacto\Diff\Diff;
use Pact\Phpacto\Pact;

class MismatchDiffOutput
{
    private $verbose;

    public function __construct($verbose = false)
    {
        $this->verbose = $verbose;
    }

    public function getOutputFor(Diff $diff, Pact $pact)
    {
        $mismatches = $diff->getMismatches();
        $output = $pact->getDescription()."\n".$pact->getProviderState()."\n".$pact->getRequest()->getMethod().' '.$pact->getRequest()->getUri()."\n";
        $errors = 0;

        foreach ($mismatches as $mismatch) {
            ++$errors;

            $output .= sprintf(
                "\n Error# %s: \n Location: %s \n Error: %s \n",
                $errors, $mismatch->getLocation(), $mismatch->getMessage()
            );
        }

        return $output;
    }
}
