<?php

/*
 * This file is part of Berny\Flow
 *
 * (c) Berny Cantos <be@rny.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Berny\Flow\Git;

use Symfony\Component\Process\ProcessBuilder;

class Git
{
    protected $processBuilder;

    public function __construct(ProcessBuilder $processBuilder = null)
    {
        if (null === $processBuilder) {
            $processBuilder = new ProcessBuilder();
            $processBuilder->setPrefix('git');
        }

        $this->processBuilder = $processBuilder;
    }

    public function createBranch($branchName, $basedAt)
    {
        $this->run('branch', $branchName, $basedAt);
    }

    public function checkoutBranch($branchName)
    {
        $this->run('checkout', $branchName);
    }

    protected function run()
    {
        $process = $this->processBuilder
            ->setArguments(func_get_args())
            ->getProcess();

        $process->run();
        if (!$process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }

        return $process;
    }
}
