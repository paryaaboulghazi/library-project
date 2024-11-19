<?php

namespace Src\tests\Unit\Commands;

use PHPUnit\Framework\TestCase;
use Src\Commands\DeleteRepositoryCommand;
use Src\Services\VCSApiInterface;

class DeleteRepositoryCommandTest extends TestCase
{
    public function testExecuteWithValidInput()
    {
        $vcsService = $this->createMock(VCSApiInterface::class);
        $vcsService->expects($this->once())
            ->method('deleteRepository')
            ->with('testUser', 'testRepo');

        $inputStream = fopen('php://memory', 'r+');
        fwrite($inputStream, "testUser\n");
        fwrite($inputStream, "testRepo\n");
        rewind($inputStream);

        $command = new DeleteRepositoryCommand($vcsService, $inputStream);

        ob_start();
        $command->execute();
        $output = ob_get_clean();

        $this->assertStringContainsString(
            "Repository 'testRepo' owned by 'testUser' was successfully deleted.",
            $output
        );
    }

    public function testExecuteWithEmptyInput()
    {
        $vcsService = $this->createMock(VCSApiInterface::class);
        $vcsService->expects($this->never())->method('deleteRepository');

        $inputStream = fopen('php://memory', 'r+');
        fwrite($inputStream, "\n");
        fwrite($inputStream, "\n");
        rewind($inputStream);

        $command = new DeleteRepositoryCommand($vcsService, $inputStream);

        ob_start();
        $command->execute();
        $output = ob_get_clean();

        $this->assertStringContainsString(
            "Username and repository name are required.",
            $output
        );
    }
}
