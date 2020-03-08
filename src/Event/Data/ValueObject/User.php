<?php declare(strict_types=1);

namespace ekinhbayar\Driver\Slack\Event\Data\ValueObject;

class User
{
    private string  $identifier;

    private ?string $name;

    public function __construct(string $identifier, ?string $name)
    {
        $this->identifier = $identifier;
        $this->name       = $name;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function getName(): ?string
    {
        return $this->name;
    }
}
