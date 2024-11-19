<?php

namespace Src\Http\Controllers;

use Src\Services\VCSApiInterface;

class RepositoryController
{
    private VCSApiInterface $vcsService;

    public function __construct(VCSApiInterface $vcsService)
    {
        $this->vcsService = $vcsService;
    }

    public function index(array $requestParams)
    {
        $username = $requestParams['username'] ?? null;
        $repositories = $this->vcsService->getRepositories($username);

        echo json_encode($repositories, JSON_PRETTY_PRINT);
    }
}