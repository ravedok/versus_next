<?php

namespace VS\Next\Tests\Behat\Context;

use PHPUnit\Framework\Assert;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use DMS\PHPUnitExtensions\ArraySubset\ArraySubsetAsserts;
use Symfony\Component\Config\Definition\Exception\InvalidTypeException;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;

class RequestContext extends Assert implements Context
{
    use SharedContextTrait;
    use ArraySubsetAsserts;

    private Response $response;

    public function __construct(private KernelInterface $kernel)
    {
    }

    /**
     * @When I send a :method request to :url
     */
    public function iSendARequestTo(string $method, string $path)
    {
        $this->request($path, $method);
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
        $bodyWithContent = $this->pyStringNodeWithContext($body);

        $json = json_encode(json_decode($bodyWithContent, true));

        if ($json === null && json_last_error() !== JSON_ERROR_NONE) {
            throw new \InvalidArgumentException("The provided body is not in a valid json format");
        }


        $this->request($path, $method, content: $json);
    }

    /**
     * @Then The response content should include:
     */
    public function theResponseContentShouldInclude(PyStringNode $body)
    {
        $bodyWithContext = $this->pyStringNodeWithContextToArray($body);

        $jsonContent = $this->response->getContent();
        $content = json_decode($jsonContent, true);

        self::assertArraySubset($bodyWithContext, $content);
    }

    /**
     * @Then The response value :path should be empty:
     */
    public function theResponseValueShouldBeEmpty(mixed $path)
    {
        $jsonContent = $this->response->getContent();

        $content = json_decode($jsonContent, true);

        $value = $this->getArrayValueFromPath($content, $path);

        $this->assertEmpty($value);
    }

    private function getArrayValueFromPath(array $array, string $path): mixed
    {
        $path = explode('.', $path);
        $temp = &$array;

        foreach ($path as $key) {
            $temp = &$temp[$key];
        }

        return $temp;
    }


    private function request(
        string $path,
        string $method,
        array $parameters = [],
        array $cookies = [],
        array $files = [],
        array $server = [],
        mixed $content = null
    ): void {

        $request = Request::create($path, $method, $parameters, $cookies, $files, $server, $content);

        $request->setSession($this->sharingContext->getSharedSession());


        $this->response = $this->kernel->handle($request);
    }

    private function getSession(): SessionInterface
    {
        if (!isset($this->session)) {
            $this->session = new Session(new MockArraySessionStorage());
        }

        return $this->session;
    }
}
