<?php declare(strict_types=1);

namespace ekinhbayar\Driver\Slack\Event\Data;

use ekinhbayar\Driver\Slack\Channel;

class ChannelMessage extends Event
{
    private string $messageBody;

    private string $author;

    private \DateTimeImmutable $timestamp;

    private Channel $channel;

    public function __construct(
        string $token,
        string $messageBody,
        string $author,
        \DateTimeImmutable $timestamp,
        Channel $channel
    ) {
        parent::__construct($token);

        $this->messageBody = $messageBody;
        $this->author      = $author;
        $this->timestamp   = $timestamp;
        $this->channel     = $channel;
    }

    public function getMessageBody(): string
    {
        return $this->messageBody;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function getTimestamp(): \DateTimeImmutable
    {
        return $this->timestamp;
    }

    public function getChannel(): Channel
    {
        return $this->channel;
    }
}
