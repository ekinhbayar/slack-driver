<?php declare(strict_types=1);

namespace ekinhbayar\Driver\Slack\Event\Data\ValueObject;

class Channel
{
    private string $identifier;

    private string $type;

    public function __construct(string $identifier, string $type)
    {
        $this->identifier = $identifier;
        $this->type       = $type;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function getType(): string
    {
        return $this->type;
    }
}
