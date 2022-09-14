<?php
declare(strict_types=1);

namespace App\Service;

use Spatie\Dropbox\Client;

class DropboxConnectService
{
    private string $appSecret;

    /**
     * @param string $appSecret
     */
    public function __construct(string $appSecret)
    {
        $this->appSecret = $appSecret;
    }

    public function connect(): Client
    {
        return new Client($this->appSecret);
    }

    public function save(string $dropboxPath, string $fileContents): void
    {
        $client = $this->connect();
        $client->upload($dropboxPath, $fileContents);
    }
}