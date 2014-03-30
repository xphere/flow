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

class StartFeatureCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('start:feature')
            ->setDescription('Starts a new feature branch.')
            ->addArgument('featureName', InputArgument::REQUIRED, 'feature name to be created')
            ->setHelp("This command eases starting a new feature branch from the devel one.\n")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $feature = $input->getArgument('featureName');
        $output->writeln('<info>Feature</info> started: <comment>' . $feature . '</comment>');
    }
}
