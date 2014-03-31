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

class InitCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('init')
            ->setDescription('Configure your repository for Flow usage.')
            ->setHelp("Setup basic configuration for running flow in your repository.\n")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $formatter = $this->getHelper('formatter');
        $flow = $this->getFlow();
        if (!$flow->isGitRepository()) {
            $output->writeln($formatter->formatBlock(array(
                'Flow init',
                'Current directory must be under control version.'
            ), 'bg=red;fg=white', true));

            return 1;
        }

        $output->writeln($formatter->formatBlock(array(
            'Flow init',
            'Initializing Flow in current repository'
        ), 'bg=blue;fg=white', true));
        $output->writeln('');

        $defaultFeaturePrefix = $flow->getFeaturePrefix();
        $featurePrefix = $this->ask($output, 'Feature prefix', $defaultFeaturePrefix);
        $flow->setFeaturePrefix($featurePrefix);

        $output->writeln('');
        $output->writeln('<info><comment>Flow</comment> was successfully configured</info>');
    }

    protected function ask(OutputInterface $output, $question, $default = null)
    {
        $question = "<info>{$question}?</info> ";
        if (null !== $default) {
            $question .= "[<comment>{$default}</comment>] ";
        }

        return $this->getHelper('dialog')->ask($output, $question, $default);
    }    
}
