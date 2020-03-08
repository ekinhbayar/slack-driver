<?php declare(strict_types=1);

namespace ekinhbayar\Driver\Slack\Client;

use Amp\Promise;
use AsyncBot\Core\Http\Client as HttpClient;
use ekinhbayar\Driver\Slack\Client\Request\Request;

final class Client
{
    private HttpClient $httpClient;

    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function request(Request $request): Promise
    {
        return $this->httpClient->makeRequest($request->getRequest());
    }
}
