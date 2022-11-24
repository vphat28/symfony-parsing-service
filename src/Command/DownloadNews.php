<?php

// src/Command/CreateUserCommand.php
namespace App\Command;

use App\Message\WebpageContent;
use App\Service\Crawler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class DownloadNews extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:download-news';

    /** @var Crawler */
    protected Crawler $crawler;

    /** @var MessageBusInterface */
    protected $bus;

    /**
     * @param Crawler $crawler
     * @param string|null $name
     */
    public function __construct(Crawler $crawler, MessageBusInterface $bus, string $name = null)
    {
        $this->crawler = $crawler;
        $this->bus = $bus;

        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->bus->dispatch(new WebpageContent('hello world'));
        // ... put here the code to create the user

        // this method must return an integer number with the "exit status code"
        // of the command. You can also use these constants to make code more readable

        // return this if there was no problem running the command
        // (it's equivalent to returning int(0))
        return Command::SUCCESS;

        // or return this if some error happened during the execution
        // (it's equivalent to returning int(1))
        // return Command::FAILURE;

        // or return this to indicate incorrect command usage; e.g. invalid options
        // or missing arguments (it's equivalent to returning int(2))
        // return Command::INVALID
    }
}
