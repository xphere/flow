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

    const INITIALIZED = 'flow.initialized';
    const FEATURE_PREFIX = 'flow.prefix.feature';

    protected $git;
    protected $config = array();

    public function __construct(Git $git)
    {
        $this->git = $git;
    }

    public function startFeature($featureName, $andCheckout)
    {
        $branchName = $this->featureBranchName($featureName);
        $this->git->createBranch($branchName, $basedAt = 'dev');
        if ($andCheckout) {
            $this->checkoutBranch($branchName);
        }
    }

    public function checkoutBranch($branchName)
    {
        if (!$this->git->hasBranch($branchName)) {
            throw new \InvalidArgumentException("Branch {$branchName} does not exist");
        }

        if ($branchName === $this->git->currentBranch()) {
            throw new \RuntimeException("Already on '{$branchName}'");
        }

        $this->git->stashSave();
        $this->git->checkoutBranch($branchName);
        $this->git->stashPop();
    }

    public function isGitRepository()
    {
        return $this->git->isRepository();
    }

    public function isInitialized()
    {
        return $this->getConfig(self::INITIALIZED);
    }

    public function markAsInitialized()
    {
        return $this->setConfig(self::INITIALIZED, true);
    }

    public function getFeaturePrefix()
    {
        return $this->getConfig(self::FEATURE_PREFIX, 'feature-');
    }

    public function setFeaturePrefix($value)
    {
        return $this->setConfig(self::FEATURE_PREFIX, $value);
    }

    protected function getConfig($configName, $default = null)
    {
        if (!array_key_exists($configName, $this->config)) {
            $result = $this->git->getConfig($configName);
            $this->config[$configName] = $result;
        } else {
            $result = $this->config[$configName];
        }

        return null === $result ? $default : $result;
    }

    protected function setConfig($configName, $value)
    {
        if (!array_key_exists($configName, $this->config) || $this->config[$configName] !== $value) {
            $this->git->setConfig($configName, $value);
            $this->config[$configName] = $value;
        }
    }

    protected function featureBranchName($featureName)
    {
        return $this->getFeaturePrefix() . $featureName;
    }
}
