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
use Symfony\Component\Console;

/**
 * Access point to the commands
 */
class Application extends Console\Application
{
    protected $flow;

    public function __construct()
    {
        parent::__construct('flow', Flow::VERSION);
    }

    public function getFlow()
    {
        if (null === $this->flow) {
            $this->flow = new Flow();
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

        return $commands;
    }
}
