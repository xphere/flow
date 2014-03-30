<?php

/*
 * This file is part of Berny\Flow
 *
 * (c) Berny Cantos <be@rny.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Berny\Flow;

class Flow
{
    const VERSION = '@package_version@';

    public function startFeature($featureName)
    {
        $branchName = $this->featureBranchName($featureName);
        $this->createBranch($branchName, $from = 'dev');
    }

    protected function featureBranchName($featureName)
    {
        return 'feature-' . $featureName;
    }

    protected function createBranch($branchName, $from)
    {
        exec('git branch ' . escapeshellarg($branchName) . ' ' . escapeshellarg($from));
    }
}
