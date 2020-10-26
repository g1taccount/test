<?php

namespace App\Command;

use App\Service\NewsImporterInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class NewsParseCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'parse';

    /**
     * @var NewsImporterInterface
     */
    public NewsImporterInterface $newsImporter;

    /**
     * NewsParseCommand constructor.
     * @param NewsImporterInterface $newsImporter
     * @param string|null $name
     */
    public function __construct(NewsImporterInterface $newsImporter, string $name = null)
    {
        parent::__construct($name);
        $this->newsImporter = $newsImporter;
    }

    protected function configure()
    {
        $this
            ->setDescription('Parse news');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $this->newsImporter->run();

        $io->success('Data was parsed.');

        return Command::SUCCESS;
    }
}
