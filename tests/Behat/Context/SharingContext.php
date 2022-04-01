<?php

namespace VS\Next\Tests\Behat\Context;

use ArrayAccess;
use Behat\Behat\Context\Context;
use Twig\Environment;

class SharingContext implements Context, ArrayAccess
{
    /** @var array */
    private $values = [];

    public function __construct(private Environment $twig)
    {
    }

    /**
     * @Transform /^(.*{{.*}}.*)$/
     */
    public function renderText($text)
    {
        $rendered = $text;
        $this->renderTwigTemplate($rendered);

        return $rendered;
    }

    /**
     * @Then print the var :var
     */
    public function printVar(string $key): void
    {
        $var = $this->values[$key];
        $strVar = json_encode($var);
        echo $key . ' = ' . $strVar;
    }

    public function renderTwigTemplate(string &$string): void
    {
        $template = $this->twig->createTemplate($string);

        $string = $this->twig->render($template, $this->values);
    }

    public function offsetExists($offset): bool
    {
        return array_key_exists($offset, $this->values);
    }

    public function offsetGet($offset)
    {
        return $this->values[$offset];
    }

    public function offsetSet($offset, $value): void
    {
        $this->values[$offset] = $value;
    }

    public function offsetUnset($offset): void
    {
        unset($this->values[$offset]);
    }

    public function merge(array $array): void
    {
        $this->values = array_merge($this->values, $array);
    }
}
