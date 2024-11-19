<?php

namespace Src\Services;

use GuzzleHttp\Client;
use Src\Core\Config;

class GitHubApiService implements VCSApiInterface
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => Config::get('github.base_uri'),
            'headers' => [
                'Authorization' => 'Bearer ' . Config::get('github.personal_access_token'),
                'Accept' => 'application/vnd.github.v3+json',
            ],
        ]);
    }

    public function createRepository(string $name, string $description, bool $private)
    {
        try {
            $response = $this->client->post('user/repos', [
                'json' => [
                    'name' => $name,
                    'description' => $description,
                    'private' => $private,
                ],
            ]);

            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            throw new \Exception("Failed to create repository.: {$e->getMessage()}");
        }
    }

    public function deleteRepository(string $username, string $repo)
    {
        try {
            $response = $this->client->delete("repos/{$username}/{$repo}");

            return $response->getStatusCode() === 204;
        } catch (\Exception $e) {
            throw new \Exception("Failed to delete repository: {$e->getMessage()}");
        }
    }

    public function getRepositories(string $username = null)
    {
        $endpoint = $username ? "users/{$username}/repos" : "user/repos";

        try {
            $response = $this->client->get($endpoint);
            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            throw new \Exception("Failed to list repositories: {$e->getMessage()}");
        }
    }
}
