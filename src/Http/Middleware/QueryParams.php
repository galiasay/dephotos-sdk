<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Http\Middleware;

use Depositphotos\SDK\Http\MiddlewareInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class QueryParams implements MiddlewareInterface
{
    /** @var mixed[] */
    private $params;

    public function __construct(array $params)
    {
        $this->params = $params;
    }

    public function execute(RequestInterface $request, callable $next): ResponseInterface
    {
        $query = [];
        parse_str($request->getUri()->getQuery(), $query);

        $params = array_merge($this->params, $query);

        $request = $request->withUri($request->getUri()->withQuery(http_build_query($params)));

        return $next($request);
    }
}
