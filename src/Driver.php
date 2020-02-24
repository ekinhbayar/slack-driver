<?php declare(strict_types=1);

namespace ekinhbayar\Driver\Slack;

use Amp\Promise;
use AsyncBot\Core\Driver as DriverInterface;
use AsyncBot\Core\Http\Server;
use AsyncBot\Core\Http\WebHook;
use ekinhbayar\Driver\Slack\Event\Listener\OnNewChannelMessage;
use function Amp\call;

final class Driver implements DriverInterface
{
    private Server $server;

    private string $webhookEndpoint;

    private EventDispatcher $eventDispatcher;

    public function __construct(Server $server, string $webhookEndpoint)
    {
        $this->server          = $server;
        $this->webhookEndpoint = $webhookEndpoint;

        $this->eventDispatcher = new EventDispatcher;
    }

    /**
     * @inheritDoc
     */
    public function start(): Promise
    {
        return call(function () {
            $this->server->registerWebHook(new WebHook('POST', $this->webhookEndpoint, $this->eventDispatcher));
        });
    }

    /**
     * @inheritDoc
     */
    public function postMessage(string $message): Promise
    {
        // TODO: Implement postMessage() method.
    }

    public function onNewMessage(OnNewChannelMessage $channelMessageListener): void
    {
        $this->eventDispatcher->addChannelMessageEventListener($channelMessageListener);
    }
}
