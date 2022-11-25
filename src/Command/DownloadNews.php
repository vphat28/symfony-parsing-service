<?php

// src/Command/CreateUserCommand.php
namespace App\Command;

use App\Message\WebpageContent;
use App\Service\Crawler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class DownloadNews extends Command
{

    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:download-news';

    /** @var Crawler */
    protected Crawler $crawler;

    /** @var MessageBusInterface */
    protected $bus;

    /** @var HttpClientInterface */
    protected $client;

    /**
     * @param  Crawler  $crawler
     * @param  string|null  $name
     */
    public function __construct(
        Crawler $crawler,
        MessageBusInterface $bus,
        HttpClientInterface $client,
        string $name = null
    ) {
        $this->crawler = $crawler;
        $this->bus     = $bus;
        $this->client  = $client;

        parent::__construct($name);
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ): int {
        $i = 1;

        while ($i < 3) {
            $response = $this->client->request('POST',
                'https://highload.today/wp-content/themes/supermc/ajax/loadarchive.php',
                [
                    'body' => [
                        'action' => 'archiveload',
                        'stick'  => '35',
                        'page'   => $i,
                        'cat'    => '537',
                    ],
                ]);

            if (!empty($response->getContent())
                && $response->getStatusCode() >= 200
                && $response->getStatusCode() < 300
            ) {
                $this->bus->dispatch(new WebpageContent($response->getContent()));
            } else {
                break;
            }

            $i++;
        }

        return Command::SUCCESS;
    }

}
