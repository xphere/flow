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

class Git
{
    public function createBranch($branchName, $basedAt)
    {
        exec('git branch ' . escapeshellarg($branchName) . ' ' . escapeshellarg($basedAt));
    }
}
