<?php declare(strict_types=1);

namespace App\Tests\Integration\Command;

use App\Command\BadCommand;
use PHPUnit\Framework\Attributes\CoversClass;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Tester\CommandTester;

#[CoversClass(BadCommand::class)]
final class BadCommandTest extends KernelTestCase
{
    public function testExecute(): void
    {
        $container = self::getContainer();

        /** @var Command $command */
        $command = $container->get(BadCommand::class);
        $helper = new QuestionHelper();
        $helperSet = new HelperSet([$helper]);
        $command->setHelperSet($helperSet);
        $commandTester = new CommandTester($command);

        $address = <<<'YAML'
        55 Rue du Faubourg Saint-Honoré
        75008
        Paris
        YAML;

        $commandTester->setInputs(
            [
                'John',
                $address,
                '0606060606',
            ]
        );
        $commandTester->execute([]);

        $output = $commandTester->getDisplay(true);
        $expectedOutput = <<<TXT
        
         What is your firstname?:
         > 
         What is your address? (press Ctrl+D to continue):
         > 
         What is your phone?:
         > 
        Your firstname is John
        Your address is 55 Rue du Faubourg Saint-Honoré
        75008
        Paris
        Your phone is 0606060606
        
        TXT;

        $this->assertSame($expectedOutput, $output);
    }
}
