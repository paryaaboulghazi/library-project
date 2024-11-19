<?php

namespace Src\tests\Unit\Commands;

use PHPUnit\Framework\TestCase;
use Src\Commands\CreateRepositoryCommand;
use Src\Services\VCSApiInterface;

class CreateRepositoryCommandTest extends TestCase
{
    public function testExecuteWithValidInput()
    {
        $vcsService = $this->createMock(VCSApiInterface::class);
        $vcsService->expects($this->once())
            ->method('createRepository')
            ->with('newRepo', 'A sample repository description.', true);

        $inputStream = fopen('php://memory', 'r+');
        fwrite($inputStream, "newRepo\n");
        fwrite($inputStream, "A sample repository description.\n");
        fwrite($inputStream, "yes\n");
        rewind($inputStream);

        $command = new CreateRepositoryCommand($vcsService, $inputStream);

        ob_start();
        $command->execute();
        $output = ob_get_clean();

        $this->assertStringContainsString(
            "Repository 'newRepo' was successfully created.",
            $output
        );
    }

    public function testExecuteWithEmptyInput()
    {
        $vcsService = $this->createMock(VCSApiInterface::class);
        $vcsService->expects($this->never())->method('createRepository');

        $inputStream = fopen('php://memory', 'r+');
        fwrite($inputStream, "\n");
        fwrite($inputStream, "A sample repository description.\n");
        fwrite($inputStream, "no\n");
        rewind($inputStream);

        $command = new CreateRepositoryCommand($vcsService, $inputStream);

        ob_start();
        $command->execute();
        $output = ob_get_clean();

        $this->assertStringContainsString(
            "Repository name is required.",
            $output
        );
    }
}
