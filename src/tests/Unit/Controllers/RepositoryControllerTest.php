<?php

namespace Src\tests\Unit\Controllers;

use PHPUnit\Framework\TestCase;
use Src\Http\Controllers\RepositoryController;
use Src\Services\VCSApiInterface;
use PHPUnit\Framework\MockObject\MockObject;

class RepositoryControllerTest extends TestCase
{
    /**
     * @var VCSApiInterface|MockObject
     */
    private $vcsServiceMock;

    /**
     * @var RepositoryController
     */
    private $controller;

    protected function setUp(): void
    {
        $this->vcsServiceMock = $this->createMock(VCSApiInterface::class);

        $this->controller = new RepositoryController($this->vcsServiceMock);
    }

    public function testIndexWithUsername()
    {
        $requestParams = ['username' => 'testUser'];
        $expectedRepositories = [
            ['name' => 'Repo1', 'url' => 'https://github.com/testUser/repo1'],
            ['name' => 'Repo2', 'url' => 'https://github.com/testUser/repo2']
        ];

        $this->vcsServiceMock
            ->expects($this->once())
            ->method('getRepositories')
            ->with('testUser')
            ->willReturn($expectedRepositories);

        ob_start();
        $this->controller->index($requestParams);
        $output = ob_get_clean();

        $this->assertJsonStringEqualsJsonString(
            json_encode($expectedRepositories, JSON_PRETTY_PRINT),
            $output
        );
    }

    public function testIndexWithoutUsername()
    {
        $requestParams = [];
        $expectedRepositories = [
            ['name' => 'Repo1', 'url' => 'https://github.com/defaultUser/repo1']
        ];

        $this->vcsServiceMock
            ->expects($this->once())
            ->method('getRepositories')
            ->with(null)
            ->willReturn($expectedRepositories);

        ob_start();
        $this->controller->index($requestParams);
        $output = ob_get_clean();

        $this->assertJsonStringEqualsJsonString(
            json_encode($expectedRepositories, JSON_PRETTY_PRINT),
            $output
        );
    }
}
