<?php declare(strict_types=1);

namespace ekinhbayar\Driver\Slack;

use Amp\Http\Client\HttpClient;
use Amp\Promise;
use AsyncBot\Core\Driver as DriverInterface;

final class Driver implements DriverInterface
{
    private HttpClient $httpClient;
    
    public function __construct(HttpClient $httpClient){
        $this->httpClient = $httpClient;
    }
    
    /**
     * @inheritDoc
     */
    public function start(): Promise
    {
        // TODO: Implement start() method.
    }

    /**
     * @inheritDoc
     */
    public function postMessage(string $message): Promise
    {
        // TODO: Implement postMessage() method.
    }
}
