<?php declare(strict_types=1);

namespace ekinhbayar\Driver\Slack;

use Amp\Promise;
use Amp\Success;
use AsyncBot\Core\Driver as DriverInterface;
use AsyncBot\Core\Http\Client as HttpClient;
use AsyncBot\Core\Http\Server;
use AsyncBot\Core\Http\WebHook;
use AsyncBot\Core\Message\Node\Message;
use ekinhbayar\Driver\Slack\Client\Client;
use ekinhbayar\Driver\Slack\Client\Request\PostMessage;
use ekinhbayar\Driver\Slack\Event\Dispatcher;
use ekinhbayar\Driver\Slack\Event\Listener\OnCommand;
use ekinhbayar\Driver\Slack\Event\Listener\OnMention;
use ekinhbayar\Driver\Slack\Event\Listener\OnNewChannelMessage;

final class Driver implements DriverInterface
{
    private Client $client;

    private Server $server;

    private Configuration $configuration;

    private Dispatcher $eventDispatcher;

    public function __construct(HttpClient $httpClient, Server $server, Configuration $configuration)
    {
        $this->client          = new Client($httpClient);
        $this->server          = $server;
        $this->configuration   = $configuration;

        $this->eventDispatcher = new Dispatcher();
    }

    /**
     * @return Promise<null>
     */
    public function start(): Promise
    {
        if ($this->configuration->hasMessageWebhook()) {
            $this->server->registerWebHook(
                new WebHook('POST', $this->configuration->getMessageWebhook(), $this->eventDispatcher),
            );
        }

        if ($this->configuration->hasCommandWebhook()) {
            $this->server->registerWebHook(
                new WebHook('POST', $this->configuration->getCommandWebhook(), $this->eventDispatcher),
            );
        }

        return new Success();
    }

    /**
     * @return Promise<null>
     */
    public function postMessage(Message $message): Promise
    {
        return $this->client->request(
            new PostMessage(
                $this->configuration->getCredentials()->getAccessToken(),
                $this->configuration->getChannel(),
                $message,
            ),
        );
    }

    public function onNewMessage(OnNewChannelMessage $channelMessageListener): void
    {
        $this->eventDispatcher->addChannelMessageEventListener($channelMessageListener);
    }

    public function onMention(OnMention $mentionListener): void
    {
        $this->eventDispatcher->addMentionEventListener($mentionListener);
    }

    public function onCommand(OnCommand $commandListener): void
    {
        $this->eventDispatcher->addCommandEventListener($commandListener);
    }
}
