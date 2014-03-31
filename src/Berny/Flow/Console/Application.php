<?php

/*
 * This file is part of Berny\Flow
 *
 * (c) Berny Cantos <be@rny.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Berny\Flow\Console;

use Berny\Flow\Command;
use Berny\Flow\Flow;
use Berny\Flow\Git\Git;
use Symfony\Component\Console;

/**
 * Access point to the commands
 */
class Application extends Console\Application
{
    protected $git;
    protected $flow;

    public function __construct()
    {
        parent::__construct('flow', Flow::VERSION);
    }

    public function getFlow()
    {
        if (null === $this->flow) {
            $this->flow = new Flow($this->getGit());
        }

        return $this->flow;
    }

    /**
     * Add commands
     */
    protected function getDefaultCommands()
    {
        $commands = parent::getDefaultCommands();
        $commands[] = new Command\VersionCommand();
        $commands[] = new Command\StartFeatureCommand();
        $commands[] = new Command\InitCommand();
        $commands[] = new Command\CheckoutCommand();

        return $commands;
    }

    protected function getGit()
    {
        if (null === $this->git) {
            $this->git = new Git();
        }

        return $this->git;
    }

}
