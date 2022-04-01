<?php

namespace VS\Next\Tests\Behat\Context;

use Behat\Gherkin\Node\PyStringNode;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Behat\Context\Environment\InitializedContextEnvironment;

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

    public function getSessionValue(string $key): void
    {
        $this->sharingContext->getSharedSession()->get($key);
    }

    public function setSessionValue(string $key, $value): void
    {
        $this->sharingContext->getSharedSession()->set($key, $value);
    }

    private function pyStringNodeWithContextToArray(PyStringNode $content): array
    {
        return json_decode($this->pyStringNodeWithContext($content), true);
    }

    private function pyStringNodeWithContext(PyStringNode $content): string
    {
        $rawContent = $content->getRaw();
        $this->renderTwigTemplate($rawContent);

        return $rawContent;
    }
}
