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

    public function currentBranch()
    {
        return $this->run('rev-parse', '--abbrev-ref', 'HEAD')
                    ->getOutput();
    }

    public function createBranch($branchName, $basedAt)
    {
        $this->runAndCheck('branch', $branchName, $basedAt);

        return $this;
    }

    public function checkoutBranch($branchName)
    {
        $this->runAndCheck('checkout', $branchName);

        return $this;
    }

    public function getConfig($configName, $scope = self::LOCAL_SCOPE)
    {
        return trim(
            $this->run('config', "--{$scope}", '--get', $configName)
                 ->getOutput()
        );
    }

    public function setConfig($configName, $value, $scope = self::LOCAL_SCOPE)
    {
        $this->runAndCheck('config', "--{$scope}", $configName, $value);

        return $this;
    }

    protected function runAndCheck()
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

    protected function run()
    {
        $process = $this->processBuilder
            ->setArguments(func_get_args())
            ->getProcess();

        $process->run();

        return $process;
    }
}
