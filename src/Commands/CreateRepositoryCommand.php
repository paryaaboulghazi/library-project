<?php

namespace Src\Commands;

use Src\Services\VCSApiInterface;

class CreateRepositoryCommand
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

        echo "Enter the repository name to create: ";
        $repositoryName = trim(fgets($handle));

        echo "Enter a description for the repository (optional): ";
        $description = trim(fgets($handle));

        echo "Is the repository private? (yes/no): ";
        $isPrivate = strtolower(trim(fgets($handle))) === 'yes';

        if (empty($repositoryName)) {
            echo "Repository name is required.\n";
            return;
        }

        $this->vcsService->createRepository($repositoryName, $description, $isPrivate);

        echo "Repository '{$repositoryName}' was successfully created.\n";
    }
}
