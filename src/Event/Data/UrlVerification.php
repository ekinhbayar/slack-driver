<?php declare(strict_types=1);

namespace ekinhbayar\Driver\Slack\Event\Data;

class UrlVerification extends Event
{
    private string $challenge;

    public function __construct(string $token, string $challenge)
    {
        parent::__construct($token);

        $this->challenge = $challenge;
    }

    public function getChallenge(): string
    {
        return $this->challenge;
    }
}
