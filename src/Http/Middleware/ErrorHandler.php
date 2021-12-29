<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Http\Middleware;

use Depositphotos\SDK\Exception\ClientException;
use Depositphotos\SDK\Http\MiddlewareInterface;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Utils;
use Psr\Http\Client\RequestExceptionInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Exception;

class ErrorHandler implements MiddlewareInterface
{
    private const TYPE_SUCCESS = 'success';

    public function execute(RequestInterface $request, callable $next): ResponseInterface
    {
        try {
            $response = $next($request);

            if ($this->isSuccess($response)) {
                return $response;
            }

            throw ClientException::create($request, $response);
        } catch (BadResponseException $e) {
            throw ClientException::create($e->getRequest(), $e->getResponse(), $e->getPrevious());
        } catch (RequestExceptionInterface $e) {
            throw ClientException::create($e->getRequest(), null, $e->getPrevious());
        } catch (Exception $e) {
            throw ClientException::create($request, null, $e->getPrevious());
        }
    }

    private function isSuccess(ResponseInterface $response): bool
    {
        $responseData = (array) Utils::jsonDecode((string) $response->getBody(), true);

        return ($responseData['type'] ?? null) === self::TYPE_SUCCESS;
    }
}