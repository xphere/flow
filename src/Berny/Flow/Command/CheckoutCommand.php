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

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CheckoutCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('checkout')
            ->setDescription('Checkout another branch.')
            ->addArgument('branch', InputArgument::REQUIRED, 'branch to switch')
            ->setHelp("Move between branches easily without losing your work.\n")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $branch = $input->getArgument('branch');
        $flow = $this->getFlow();
        $flow->selectBranch($branch);

        $output->writeln("Switched to branch '{$branch}'");
    }
}
