<?php declare(strict_types=1);

namespace ekinhbayar\Driver\Slack\Event\Exception;

use ekinhbayar\Driver\Slack\Exception\Exception;

final class EventNotImplemented extends Exception
{
    public function __construct(string $event)
    {
        parent::__construct(
            sprintf('%s event not implemented', $event),
        );
    }
}
