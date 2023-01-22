<?php

declare(strict_types=1);

namespace Devbanana\LetterBoxed\Command;

use Devbanana\LetterBoxed\Util\StripWords;
use Devbanana\LetterBoxed\Validator\WordValidator;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'remaining', description: 'Determine remaining letters after word(s)')]
final class RemainingCommand extends Command
{
    private WordValidator $wordValidator;
    private StripWords $stripWords;

    public function __construct(WordValidator $wordValidator, StripWords $stripWords)
    {
        $this->wordValidator = $wordValidator;
        $this->stripWords = $stripWords;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setHelp('Determine which letters are left after the given words')
            ->addArgument('letters', InputArgument::REQUIRED | InputArgument::IS_ARRAY, 'The letters of the puzzle (each side separated by a space)')
            ->addOption('word', 'w', InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, 'The word(s) in the puzzle so far')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->title('Remaining');

        $letters = $input->getArgument('letters');
        if (!\is_array($letters) || \count($letters) !== 4) {
            $io->getErrorStyle()->error('There must be exactly 4 sets of letters.');

            return Command::INVALID;
        }

        $words = $input->getOption('word');
        if (!\is_array($words) || empty($words)) {
            $io->getErrorStyle()->error('At least 1 word is required.');

            return Command::INVALID;
        }

        if (!$this->wordValidator->validate($words, $letters)) {
            $io->getErrorStyle()->error('The provided words are invalid.');

            return Command::INVALID;
        }

        $remaining = $this->stripWords->strip($words, $letters);

        if (!empty($remaining)) {
            $io->writeln('The remaining letters are:');
            $io->writeln($remaining);
        } else {
            $io->writeln("<info>You've solved the puzzle! All the letters were used.</info>");
        }

        return Command::SUCCESS;
    }
}
