<?php

namespace VS\Next\Tests\Behat\Context;

use PHPUnit\Framework\Assert;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use DMS\PHPUnitExtensions\ArraySubset\ArraySubsetAsserts;

class RequestContext extends Assert implements Context
{
    use SharedContextTrait;
    use ArraySubsetAsserts;

    private Response $response;

    public function __construct(private KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @When I send a :method request to :url
     */
    public function iSendARequestTo(string $method, string $path)
    {
        $this->response = $this->kernel->handle(Request::create($path, $method));
    }

    /**
     * @Then the response status code should be :statusCode
     */
    public function theResponseStatusCodeShouldBe(int $statusCode)
    {
        $this->assertEquals($statusCode, $this->response->getStatusCode());
    }

    /**
     * @When I send a :method request to :path with body:
     */
    public function iSendARequestToWithBody(string $method, string $path, PyStringNode $body)
    {
        $rawBody = $body->getRaw();
        $this->renderTwigTemplate($rawBody);

        $json = json_encode(json_decode($rawBody, true));

        $this->response = $this->kernel->handle(Request::create($path, $method, [], [], [], [],  $json));
    }

    /**
     * @Then the response content should include:
     */
    public function theResponseContentShouldInclude(PyStringNode $body)
    {
        $rawBody = $body->getRaw();
        $this->renderTwigTemplate($rawBody);

        $content = $this->response->getContent();
        $jsonContent = json_decode($content, true);

        $jsonBody = json_decode($rawBody, true);

        self::assertArraySubset($jsonBody, $jsonContent);
    }
}
