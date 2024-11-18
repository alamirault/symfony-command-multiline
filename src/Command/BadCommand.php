<?php declare(strict_types=1);

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand('app:bad-command')]
final class BadCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $symfonyStyle = new SymfonyStyle($input, $output);

        $firstname = $symfonyStyle->ask('What is your firstname?');

        $question = new Question('What is your address?');
        $question->setMultiline(true);
        $address = $symfonyStyle->askQuestion($question);

        $phone = $symfonyStyle->ask('What is your phone?');

        $output->writeln(
            sprintf(
                'Your firstname is <info>%s</info>',
                $firstname,
            )
        );
        $output->writeln(
            sprintf(
                'Your address is <info>%s</info>',
                $address
            )
        );
        $output->writeln(
            sprintf(
                'Your phone is <info>%s</info>',
                $phone,
            )
        );

        return Command::SUCCESS;
    }
}
