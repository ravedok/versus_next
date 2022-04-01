<?php

namespace VS\Next\Tests\Behat\Context;

use Behat\Behat\Context\Environment\InitializedContextEnvironment;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;

trait SharedContextTrait
{
    private SharingContext $sharingContext;

    /**
     * @BeforeScenario
     */
    public function gatherSharingContext(BeforeScenarioScope $scope): void
    {
        /** @var InitializedContextEnvironment $environment */
        $environment = $scope->getEnvironment();

        $this->sharingContext = $environment->getContext(SharingContext::class);
    }

    public function renderTwigTemplate(string &$string): void
    {
        $this->sharingContext->renderTwigTemplate($string);
    }

    public function save(string $key, $value): void
    {
        $this->sharingContext->merge([$key => $value]);
    }
}
