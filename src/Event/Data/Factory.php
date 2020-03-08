<?php declare(strict_types=1);

namespace ekinhbayar\Driver\Slack\Event\Data;

use Amp\Http\Server\Request;
use Amp\Promise;
use ekinhbayar\Driver\Slack\Event\Exception\EventNotImplemented;
use ekinhbayar\Driver\Slack\Webhook\RequestParser\Command as CommandParser;
use ekinhbayar\Driver\Slack\Webhook\RequestParser\NewChannelMessage as NewChannelMessageParser;
use ekinhbayar\Driver\Slack\Webhook\RequestParser\UrlVerification as UrlVerificationParser;
use function Amp\call;
use function ExceptionalJSON\decode;

class Factory
{
    /**
     * @return Promise<Event>
     */
    public function build(Request $request): Promise
    {
        return call(function () use ($request) {
            return $this->parseRequest(
                yield $this->parseRequestBody($request),
            );
        });
    }

    /**
     * @return Promise<array<string,mixed>>
     */
    private function parseRequestBody(Request $request): Promise
    {
        return call(static function () use ($request) {
            $requestBody = yield $request->getBody()->buffer();

            if ($request->getHeader('Content-Type') === 'application/x-www-form-urlencoded') {
                parse_str(urldecode($requestBody), $parsedBody);

                $parsedBody['type'] = 'command';

                return $parsedBody;
            }

            return decode($requestBody, true);
        });
    }

    /**
     * @param array<string,mixed> $parsedBody
     * @throws EventNotImplemented
     */
    private function parseRequest(array $parsedBody): Event
    {
        switch ($parsedBody['type']) {
            case 'url_verification':
                return (new UrlVerificationParser($parsedBody))->parse();

            case 'command':
                return (new CommandParser($parsedBody))->parse();

            case 'event_callback':
                return $this->parseEventCallbackRequest($parsedBody);

            default:
                throw new EventNotImplemented($parsedBody['type']);
        }
    }

    /**
     * @param array<string,mixed> $parsedBody
     * @throws EventNotImplemented
     */
    private function parseEventCallbackRequest(array $parsedBody): Event
    {
        switch ($parsedBody['event']['type']) {
            case 'message':
            case 'app_mention':
                return (new NewChannelMessageParser($parsedBody))->parse();

            default:
                throw new EventNotImplemented($parsedBody['event']['type']);
        }
    }
}
