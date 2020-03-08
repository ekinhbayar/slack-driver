<?php declare(strict_types=1);

namespace ekinhbayar\Driver\Slack\Event\Listener;

use Amp\Promise;
use ekinhbayar\Driver\Slack\Event\Data\ChannelMessage;

interface OnNewChannelMessage
{
    /**
     * @return Promise<null>
     */
    public function __invoke(ChannelMessage $channelMessage): Promise;
}
