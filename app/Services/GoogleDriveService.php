<?php

namespace App\Services;

use Google\Service\Drive\Permission;

// use google\Client as GoogleClient;

class GoogleDriveService
{
    /**
     * Create a new class instance.
     */
    protected $client;
    protected $service;
    public function __construct()
    {
        // $this->client = new GoogleClient();
        $this->client = new \Google_Client();
        $this->client->setClientId(config('filesystems.disks.google.clientId'));
        $this->client->setClientSecret(config('filesystems.disks.google.clientSecret'));
        $this->client->refreshToken(config('filesystems.disks.google.refreshToken'));
        $this->service = new \Google_Service_Drive($this->client);
        dd($this->service);
    }
    public function getAccessToken()
    {
        $token = $this->client->getAccessToken();

        if ($this->client->isAccessTokenExpired()) {
            $token = $this->client->fetchAccessTokenWithRefreshToken($this->client->refreshToken());
        }
        return $token['access_token'];
    }

    public function makeFileToPublic($driveFileId)
    {
        // return $this->client;
        $permission = new Permission([
            'type' => 'anyone',
            'role' => 'reader',
        ]);
        $this->service->permissions->create($driveFileId, $permission);
    }
}
