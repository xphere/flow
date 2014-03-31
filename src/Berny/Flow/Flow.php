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
            $this->selectBranch($branchName);
        }
    }

    public function selectBranch($branchName)
    {
        $this->git->checkoutBranch($branchName);
    }

    public function isGitRepository()
    {
        return $this->git->isRepository();
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
