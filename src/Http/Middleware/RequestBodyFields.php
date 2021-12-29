<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Http\Middleware;

use Depositphotos\SDK\Http\MiddlewareInterface;
use GuzzleHttp\Psr7;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class RequestBodyFields implements MiddlewareInterface
{
    /** @var mixed[] */
    private $fields;

    public function __construct(array $fields)
    {
        $this->fields = $fields;
    }

    public function execute(RequestInterface $request, callable $next): ResponseInterface
    {
        $fields = array_merge($this->fields, (array) json_decode((string) $request->getBody(), true));

        $request = $request->withBody(Psr7\Utils::streamFor((string) json_encode($fields)));

        return $next($request);
    }
}
