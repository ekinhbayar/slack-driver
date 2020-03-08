<?php declare(strict_types=1);

namespace ekinhbayar\Driver\Slack\Webhook\RequestParser;

use ekinhbayar\Driver\Slack\Event\Data\ChannelMessage;
use ekinhbayar\Driver\Slack\Event\Data\Mention;
use ekinhbayar\Driver\Slack\Event\Data\ValueObject\Channel;
use ekinhbayar\Driver\Slack\Event\Data\ValueObject\User;

final class NewChannelMessage
{
    /** @var array<string,mixed> */
    private array $eventData;

    /**
     * @param array<string,mixed> $eventData
     */
    public function __construct(array $eventData)
    {
        $this->eventData = $eventData;
    }

    public function parse(): ChannelMessage
    {
        $eventData = [
            $this->eventData['token'],
            $this->eventData['event']['text'],
            $this->parseUser(),
            \DateTimeImmutable::createFromFormat('U.u', $this->eventData['event']['ts']),
            $this->parseChannel(),
        ];

        if ($this->eventData['event']['type'] === 'message') {
            return new ChannelMessage(...$eventData);
        }

        return new Mention(...$eventData);
    }

    private function parseUser(): User
    {
        return new User($this->eventData['event']['user']);
    }

    private function parseChannel(): Channel
    {
        return new Channel(
            $this->eventData['event']['channel'],
            $this->eventData['event']['channel_type'],
        );
    }
}
