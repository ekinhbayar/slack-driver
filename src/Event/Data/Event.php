<?php declare(strict_types=1);

namespace ekinhbayar\Driver\Slack\Event\Data;

abstract class Event
{
    private string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function getToken(): string
    {
        return $this->token;
    }
}
