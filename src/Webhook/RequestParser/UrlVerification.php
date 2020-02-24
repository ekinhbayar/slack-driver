<?php declare(strict_types=1);

namespace ekinhbayar\Driver\Slack\Webhook\RequestParser;

use ekinhbayar\Driver\Slack\Event\Data\UrlVerification as UrlVerificationEvent;

class UrlVerification
{
    /** @var array<string,mixed> */
    private array $handshakeData;

    public function __construct(array $handshakeData)
    {
        $this->handshakeData = $handshakeData;
    }

    public function parse(): UrlVerificationEvent
    {
        return new UrlVerificationEvent(
            $this->handshakeData['token'],
            $this->handshakeData['challenge']
        );
    }
}
