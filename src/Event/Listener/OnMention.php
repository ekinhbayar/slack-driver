<?php declare(strict_types=1);

namespace ekinhbayar\Driver\Slack\Event\Listener;

use Amp\Promise;
use ekinhbayar\Driver\Slack\Event\Data\Mention;

interface OnMention
{
    /**
     * @return Promise<null>
     */
    public function __invoke(Mention $mention): Promise;
}
