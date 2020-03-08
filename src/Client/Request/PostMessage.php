<?php declare(strict_types=1);

namespace ekinhbayar\Driver\Slack\Client\Request;

use AsyncBot\Core\Message\Node\Message;
use ekinhbayar\Driver\Slack\Event\Data\ValueObject\Channel;
use ekinhbayar\Driver\Slack\Message\Formatter;
use League\Uri\Http;
use function ExceptionalJSON\encode;

final class PostMessage extends AuthenticatedRequest
{
    public function __construct(string $accessToken, Channel $channel, Message $message)
    {
        parent::__construct($accessToken, Http::createFromString('https://slack.com/api/chat.postMessage'));

        $this->request->setBody(encode([
            'channel' => $channel->getIdentifier(),
            'text'    => (new Formatter())->format($message),
        ]));
    }
}
