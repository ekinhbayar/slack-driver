<?php declare(strict_types=1);

namespace ekinhbayar\Driver\Slack;

use ekinhbayar\Driver\Slack\Event\Data\ValueObject\Channel;

final class Configuration
{
    private Credentials $credentials;

    private Channel $channel;

    private ?string $messageWebhook = null;

    private ?string $commandWebhook = null;

    public function __construct(Credentials $credentials, Channel $channel)
    {
        $this->credentials = $credentials;
        $this->channel     = $channel;
    }

    public function setMessageWebhook(string $path): self
    {
        $this->messageWebhook = $path;

        return $this;
    }

    public function setCommandWebhook(string $path): self
    {
        $this->commandWebhook = $path;

        return $this;
    }

    public function getCredentials(): Credentials
    {
        return $this->credentials;
    }

    public function hasMessageWebhook(): bool
    {
        return $this->messageWebhook !== null;
    }

    public function getMessageWebhook(): ?string
    {
        return $this->messageWebhook;
    }

    public function hasCommandWebhook(): bool
    {
        return $this->commandWebhook !== null;
    }

    public function getCommandWebhook(): ?string
    {
        return $this->commandWebhook;
    }

    public function getChannel(): Channel
    {
        return $this->channel;
    }
}
