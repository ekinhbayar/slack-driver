<?php declare(strict_types=1);

namespace ekinhbayar\Driver\Slack\Client\Request;

use Amp\Http\Client\Request as HttpClientRequest;
use Psr\Http\Message\UriInterface;

abstract class Request
{
    protected HttpClientRequest $request;

    public function __construct(UriInterface $uri, string $method = 'POST')
    {
        $this->request = new HttpClientRequest($uri, $method);

        $this->request->addHeader('Content-Type', 'application/json; charset=utf-8');
    }

    public function getRequest(): HttpClientRequest
    {
        return $this->request;
    }
}
