<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Http\Middleware;

use Depositphotos\SDK\Exception\ClientException;
use Depositphotos\SDK\Http\MiddlewareInterface;
use GuzzleHttp\Psr7;
use GuzzleHttp\Utils;
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
        $contentType = $request->getHeaderLine('Content-Type');

        switch ($contentType) {
            case 'application/json':
                $fields = array_merge($this->fields, (array) Utils::jsonDecode((string) $request->getBody(), true));
                $request = $request->withBody(Psr7\Utils::streamFor(Utils::jsonEncode($fields)));
                break;
            case 'application/x-www-form-urlencoded':
                $fields = [];
                parse_str((string) $request->getBody(), $fields);
                $request = $request->withBody(Psr7\Utils::streamFor(http_build_query(array_merge($this->fields, $fields))));
                break;
            default:
                throw new ClientException(sprintf('Content type "%s" is not supported', $contentType), 0, $request);
        }

        return $next($request);
    }
}
