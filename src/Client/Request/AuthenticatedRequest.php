<?php declare(strict_types=1);

namespace ekinhbayar\Driver\Slack\Client\Request;

use Psr\Http\Message\UriInterface;

abstract class AuthenticatedRequest extends Request
{
    public function __construct(string $accessToken, UriInterface $uri, string $method = 'POST')
    {
        parent::__construct($uri, $method);

        $this->request->addHeader('Authorization', sprintf('Bearer %s', $accessToken));
    }
}
