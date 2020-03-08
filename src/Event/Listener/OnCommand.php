<?php declare(strict_types=1);

namespace ekinhbayar\Driver\Slack\Event\Listener;

use Amp\Promise;
use ekinhbayar\Driver\Slack\Event\Data\Command;

interface OnCommand
{
    /**
     * @return Promise<null>
     */
    public function __invoke(Command $mention): Promise;
}
