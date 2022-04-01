<?php

namespace VS\Next\Tests\Behat\Context;

use Behat\Behat\Context\Environment\InitializedContextEnvironment;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

trait SharedSessionTrait
{
    private SessionInterface $sharingSession;

    /**
     * @BeforeScenario
     */
    public function gatherSharingSession(BeforeScenarioScope $scope): void
    {
        /** @var InitializedContextEnvironment $environment */
        $environment = $scope->getEnvironment();

        $this->sharingSession = $environment->getContext(SharingSession::class);
    }

    private function getSessionValue(string $key): void
    {
        $this->sharingSession->get($key);
    }

    private function setSessionValue(string $key, $value): void
    {
        $this->sharingSession->set($key, $value);
    }
}
