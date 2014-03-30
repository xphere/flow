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

    const GLOBAL_SCOPE = 'global';
    const LOCAL_SCOPE  = 'local';
    const SYSTEM_SCOPE = 'system';

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

    public function getConfig($configName, $scope = self::LOCAL_SCOPE)
    {
        return $this->run('config', '--get', $configName, "--{$scope}")
                    ->getOutput();
    }

    public function setConfig($configName, $value, $scope = self::LOCAL_SCOPE)
    {
        return $this->run('config', '--set', $configName, "--{$scope}")
                    ->getOutput();
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
