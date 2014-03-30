<?php

/*
 * This file is part of Berny\Flow
 *
 * (c) Berny Cantos <be@rny.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Berny\Flow\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class VersionCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('version')
            ->setDescription('Shows current Flow version.')
            ->setHelp("The <info>version</info> command shows what version of this tool you're running\n")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Flow version: ' . $this->getVersion());
    }

    protected function getVersion()
    {
        return $this->getApplication()->getVersion();
    }    
}
