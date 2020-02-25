<?php declare(strict_types=1);

namespace ekinhbayar\Driver\Slack\Webhook\RequestParser;

use ekinhbayar\Driver\Slack\Channel;
use ekinhbayar\Driver\Slack\Event\Data\Mention;

class NewMention
{
    /** @var array<string,mixed> */
    private array $eventData;

    public function __construct(array $eventData)
    {
        $this->eventData = $eventData;
    }

    public function parse(): Mention
    {
        return new Mention(
            $this->eventData['token'],
            $this->eventData['event']['text'],
            $this->eventData['event']['user'],
            \DateTimeImmutable::createFromFormat('U.u', $this->eventData['event']['ts']),
            new Channel($this->eventData['event']['channel'], $this->eventData['event']['channel_type'])
        );
    }
}
