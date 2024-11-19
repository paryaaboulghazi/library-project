<?php

namespace Src\Commands;

use Src\Services\VCSApiInterface;

class DeleteRepositoryCommand
{
    private VCSApiInterface $vcsService;
    private $inputStream;

    public function __construct(VCSApiInterface $vcsService, $inputStream = null)
    {
        $this->vcsService = $vcsService;
        $this->inputStream = $inputStream ?? fopen('php://stdin', 'r');
    }

    public function execute(): void
    {
        $handle = $this->inputStream;

        echo "Enter the username (repository owner): ";
        $username = trim(fgets($handle));

        echo "Enter the repository name to delete: ";
        $repositoryName = trim(fgets($handle));

        if (empty($username) || empty($repositoryName)) {
            echo "Username and repository name are required.\n";
            return;
        }

        $this->vcsService->deleteRepository($username, $repositoryName);

        echo "Repository '{$repositoryName}' owned by '{$username}' was successfully deleted.\n";
    }
}
