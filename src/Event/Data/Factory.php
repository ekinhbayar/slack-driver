<?php declare(strict_types=1);

namespace ekinhbayar\Driver\Slack\Event\Data;

use Amp\Http\Server\Request;
use Amp\Promise;
use ekinhbayar\Driver\Slack\Webhook\RequestParser\NewChannelMessage;
use ekinhbayar\Driver\Slack\Webhook\RequestParser\UrlVerification as UrlVerificationParser;
use function Amp\call;
use function ExceptionalJSON\decode;

class Factory
{
    public function build(Request $request): Promise
    {
        return call(function () use ($request) {
            $body = yield $request->getBody()->buffer();

            $parsedBody = decode($body, true);

            return $this->parseRequest($parsedBody);
        });
    }

    /**
     * @param array $parsedBody
     * @return Event
     * @throws \Exception
     */
    private function parseRequest(array $parsedBody): Event
    {
        switch ($parsedBody['type']) {
            case 'url_verification':
                return (new UrlVerificationParser($parsedBody))->parse();
            case 'event_callback':
                return $this->parseEventCallbackRequest($parsedBody);
            default:
                throw new \Exception('Event is not implemented (yet).');
        }
    }

    /**
     * @param array<string,mixed> $parsedBody
     * @throws \Exception
     */
    private function parseEventCallbackRequest(array $parsedBody): Event
    {
        switch ($parsedBody['event']['type']) {
            case 'message':
                return (new NewChannelMessage($parsedBody))->parse();
            default:
                throw new \Exception('Event is not implemented (yet).');
        }
    }
}
