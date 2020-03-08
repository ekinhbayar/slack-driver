<?php declare(strict_types=1);

namespace ekinhbayar\Driver\Slack\Message\Exception;

use AsyncBot\Core\Message\Node\Node;
use ekinhbayar\Driver\Slack\Exception\Exception;

final class UnsupportedNode extends Exception
{
    public function __construct(Node $node)
    {
        parent::__construct(
            sprintf('Formatting of node %s has not been implemented (yet)', get_class($node)),
        );
    }
}
