<?php

// src/Command/ImportGuidelinesCommand.php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpClient\HttpClient;

#[AsCommand(
    name: 'app:import-guidelines',
    description: 'Creates a guideline.',
    hidden: false,
    aliases: ['app:add-guidelines']
)]
class ImportGuidelinesCommand extends Command
{
    protected static $defaultName = 'app:import-guidelines';
    protected static $defaultDescription = 'Test';

    public function __construct(bool $test = false)
    {
        // best practices recommend to call the parent constructor first and
        // then set your own properties. That wouldn't work in this case
        // because configure() needs the properties set in this constructor
        $this->test = $test;

        parent::__construct();
    }

    protected function configure(): void
    {
        //
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Access token request
        $client = HttpClient::create();
        $response = $client->request('POST', 'https://rdbauth.staging.sidekickit.nl/token',
            [
                'body' => [
                    'grant_type' => 'client_credentials',
                    'client_id' => 'f8ceed63597fd9a05b942bbb58360430',
                    'client_secret' => '402ebc5ce2b94fd803518d97364b5d0ceecf291975f5c265b6fd69f7e974c85b62e6dcd770c8814a18c9b71e8a064678313d74206d3c9118be8f09c454b2bb5d'
                ],
            ]);

        $responseArray = $response->toArray();

        // Rest API
        $client = HttpClient::create();
        $response = $client->request('GET', 'https://rdbapi.staging.sidekickit.nl/guidelines',
            [
                'headers' => [
                    'Authorization' =>  $responseArray['token_type'] . ' ' . $responseArray['access_token'],
                ],
            ]);
        dump($response->toArray()); die;

        return Command::SUCCESS;
    }
}