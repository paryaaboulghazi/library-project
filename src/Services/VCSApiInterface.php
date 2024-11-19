<?php

namespace Src\Services;

interface VCSApiInterface
{
    public function createRepository(string $name, string $description, bool $private);
    public function deleteRepository(string $username, string $repo);
    public function getRepositories(string $username = null);
}