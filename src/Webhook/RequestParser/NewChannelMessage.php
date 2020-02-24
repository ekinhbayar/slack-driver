<?php declare(strict_types=1);

namespace ekinhbayar\Driver\Slack\Webhook\RequestParser;

use DateTimeImmutable;
use ekinhbayar\Driver\Slack\Channel;
use ekinhbayar\Driver\Slack\Event\Data\ChannelMessage;

class NewChannelMessage
{
    /** @var array<string,mixed> */
    private array $eventData;

    public function __construct(array $eventData)
    {
        $this->eventData = $eventData;
    }

    public function parse(): ChannelMessage
    {
        return new ChannelMessage(
            $this->eventData['token'],
            $this->eventData['event']['text'],
            $this->eventData['event']['user'],
            DateTimeImmutable::createFromFormat('U.u', $this->eventData['event']['ts']),
            new Channel($this->eventData['event']['channel'], $this->eventData['event']['channel_type'])
        );
    }
}
