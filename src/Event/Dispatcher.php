<?php declare(strict_types=1);

namespace ekinhbayar\Driver\Slack\Event;

use Amp\Http\Server\Request;
use Amp\Http\Server\Response;
use Amp\Http\Status;
use Amp\Promise;
use AsyncBot\Core\Http\WebHookListener;
use ekinhbayar\Driver\Slack\Event\Data\ChannelMessage;
use ekinhbayar\Driver\Slack\Event\Data\Command;
use ekinhbayar\Driver\Slack\Event\Data\Factory;
use ekinhbayar\Driver\Slack\Event\Data\Mention;
use ekinhbayar\Driver\Slack\Event\Listener\OnCommand;
use ekinhbayar\Driver\Slack\Event\Listener\OnMention;
use ekinhbayar\Driver\Slack\Event\Listener\OnNewChannelMessage;
use function Amp\call;

class Dispatcher implements WebHookListener
{
    private array $listeners = [
        ChannelMessage::class => [],
        Mention::class => [],
        Command::class => [],
    ];

    public function addChannelMessageEventListener(OnNewChannelMessage $channelMessageListener): void
    {
        $this->listeners[ChannelMessage::class][] = $channelMessageListener;
    }

    public function addMentionEventListener(OnMention $mentionListener): void
    {
        $this->listeners[Mention::class][] = $mentionListener;
    }

    public function addCommandEventListener(OnCommand $mentionListener): void
    {
        $this->listeners[Command::class][] = $mentionListener;
    }

    /**
     * @return Promise<Response>
     */
    public function __invoke(Request $request): Promise
    {
        return call(function () use ($request) {
            $event = yield (new Factory())->build($request);

            if (!array_key_exists(get_class($event), $this->listeners)) {
                // @todo: throw exception? or at least log

                return new Response(Status::OK);
            }

            foreach ($this->listeners[get_class($event)] as $listener) {
                yield $listener($event);
            }

            return new Response(Status::OK);
        });
    }
}
