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

use Berny\Flow\Git\Git;

class Flow
{
    const VERSION = '@package_version@';

    protected $git;

    public function __construct(Git $git)
    {
        $this->git = $git;
    }

    public function startFeature($featureName)
    {
        $branchName = $this->featureBranchName($featureName);
        $this->git->createBranch($branchName, $basedAt = 'dev');
    }

    protected function featureBranchName($featureName)
    {
        return 'feature-' . $featureName;
    }
}
