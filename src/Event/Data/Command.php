<?php declare(strict_types=1);

namespace ekinhbayar\Driver\Slack\Event\Data;

use ekinhbayar\Driver\Slack\Event\Data\ValueObject\Channel;
use ekinhbayar\Driver\Slack\Event\Data\ValueObject\User;

class Command extends Event
{
    private string $identifier;

    private string $bodyText;

    private User $author;

    private Channel $channel;

    private string $responseUrl;

    private string $triggerId;

    public function __construct(
        string $token,
        string $identifier,
        string $bodyText,
        User $author,
        Channel $channel,
        string $responseUrl,
        string $triggerId
    ) {
        parent::__construct($token);

        $this->identifier  = $identifier;
        $this->bodyText    = $bodyText;
        $this->author      = $author;
        $this->channel     = $channel;
        $this->responseUrl = $responseUrl;
        $this->triggerId   = $triggerId;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function getBodyText(): string
    {
        return $this->bodyText;
    }

    public function getAuthor(): User
    {
        return $this->author;
    }

    public function getChannel(): Channel
    {
        return $this->channel;
    }

    public function getResponseUrl(): string
    {
        return $this->responseUrl;
    }

    public function getTriggerId(): string
    {
        return $this->triggerId;
    }
}
