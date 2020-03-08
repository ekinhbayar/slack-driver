<?php declare(strict_types=1);

namespace ekinhbayar\Driver\Slack;

use Amp\Http\Server\Request;
use Amp\Http\Server\Response;
use Amp\Http\Status;
use Amp\Promise;
use AsyncBot\Core\Http\WebHookListener;
use ekinhbayar\Driver\Slack\Event\Data\ChannelMessage;
use ekinhbayar\Driver\Slack\Event\Data\Command;
use ekinhbayar\Driver\Slack\Event\Data\Factory;
use ekinhbayar\Driver\Slack\Event\Data\Mention;
use ekinhbayar\Driver\Slack\Event\Listener\OnNewChannelMessage;
use ekinhbayar\Driver\Slack\Event\Listener\OnNewCommand;
use ekinhbayar\Driver\Slack\Event\Listener\OnNewMention;
use function Amp\call;

class EventDispatcher implements WebHookListener
{
    private array $listeners = [
        ChannelMessage::class => [],
        Command::class => [],
    ];

    public function addChannelMessageEventListener(OnNewChannelMessage $channelMessageListener): void
    {
        $this->listeners[ChannelMessage::class][] = $channelMessageListener;
    }

    public function addMentionEventListener(OnNewMention $mentionListener): void
    {
        $this->listeners[ChannelMessage::class][] = $mentionListener;
    }

    public function addCommandEventListener(OnNewCommand $mentionListener): void
    {
        $this->listeners[Command::class][] = $mentionListener;
    }

    public function __invoke(Request $request): Promise
    {
        return call(function () use ($request) {
            $event = yield (new Factory())->build($request);

            foreach ($this->listeners[get_class($event)] as $listener) {
                yield $listener($event);
            }

            return new Response(Status::OK);
        });
    }
}
