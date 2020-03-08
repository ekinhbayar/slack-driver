<?php declare(strict_types=1);

namespace ekinhbayar\Driver\Slack;

final class Credentials
{
    private string $accessToken;

    public function __construct(string $accessToken)
    {
        $this->accessToken = $accessToken;
    }

    public function getAccessToken(): string
    {
        return $this->accessToken;
    }
}
