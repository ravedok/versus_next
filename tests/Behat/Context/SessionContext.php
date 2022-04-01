<?php

namespace VS\Next\Tests\Behat\Context;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use VS\Next\Tests\Behat\Context\SharedContextTrait;

class SessionContext implements Context
{
    use SharedContextTrait;

    /**
     * @Given The session variable :sessionVarName contain:
     */
    public function theSessionVariableContain(string $sessionVarName, PyStringNode $content)
    {
        $contentWithContext = $this->pyStringNodeWithContextToArray($content);

        $this->setSessionValue($sessionVarName, $contentWithContext);
    }
}
