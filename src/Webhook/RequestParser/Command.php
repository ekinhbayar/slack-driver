<?php declare(strict_types=1);

namespace ekinhbayar\Driver\Slack\Webhook\RequestParser;

use ekinhbayar\Driver\Slack\Event\Data\Command as EventData;
use ekinhbayar\Driver\Slack\Event\Data\ValueObject\Channel;
use ekinhbayar\Driver\Slack\Event\Data\ValueObject\User;

final class Command
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

    public function parse(): EventData
    {
        return new EventData(
            $this->eventData['token'],
            $this->eventData['command'],
            $this->eventData['text'],
            $this->parseUser(),
            $this->parseChannel(),
            $this->eventData['response_url'],
            $this->eventData['trigger_id'],
        );
    }

    private function parseUser(): User
    {
        return new User(
            $this->eventData['user_id'],
            $this->eventData['user_name'] ?: null,
        );
    }

    private function parseChannel(): Channel
    {
        return new Channel(
            $this->eventData['channel'],
            'channel',
        );
    }
}
