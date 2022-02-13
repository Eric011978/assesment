<?php

// src/Command/ImportGuidelinesCommand.php
namespace App\Command;

use App\Entity\Guideline;
use App\Entity\GuidelineNavigation;
use App\Entity\Module;
use App\Entity\ModuleHyperlink;
use App\Entity\ModuleReference;
use Doctrine\Persistence\ManagerRegistry;
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

    public function __construct(bool $test = false, ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
        $this->entityManager = $doctrine->getManager();
        $this->apiUrl = 'https://rdbapi.staging.sidekickit.nl';

        $this->authenticate();

        parent::__construct();
    }

    protected function configure(): void
    {
        //
    }

    private function authenticate(): void {
        $client = HttpClient::create();

        $tokenResponse = $client->request('POST', 'https://rdbauth.staging.sidekickit.nl/token',
            [
                'body' => [
                    'grant_type' => 'client_credentials',
                    'client_id' => 'f8ceed63597fd9a05b942bbb58360430',
                    'client_secret' => '402ebc5ce2b94fd803518d97364b5d0ceecf291975f5c265b6fd69f7e974c85b62e6dcd770c8814a18c9b71e8a064678313d74206d3c9118be8f09c454b2bb5d'
                ],
            ])->toArray();

        $this->authHeaders = ['Authorization' =>  $tokenResponse['token_type'] . ' ' . $tokenResponse['access_token']];
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->truncateTables();

        $this->importGuidelines();
        $this->importModules();
        $this->importGuideNavigations();
        $this->importModuleReferences();
        $this->importModuleHyperlinks();

        return Command::SUCCESS;
    }

    private function truncateTables() {
        $connection = $this->entityManager->getConnection();
        $platform   = $connection->getDatabasePlatform();

        $connection->executeQuery('SET FOREIGN_KEY_CHECKS = 0;');
        $connection->executeUpdate($platform->getTruncateTableSQL('module_hyperlink', true));
        $connection->executeUpdate($platform->getTruncateTableSQL('module_reference', true));
        $connection->executeUpdate($platform->getTruncateTableSQL('guideline_navigation', true));
        $connection->executeUpdate($platform->getTruncateTableSQL('guideline', true));
        $connection->executeUpdate($platform->getTruncateTableSQL('module', true));
        $connection->executeQuery('SET FOREIGN_KEY_CHECKS = 1;');
    }

    private function getRequestToApi($endpoint) {
        $client = HttpClient::create();

        return $client->request('GET', $this->apiUrl . '/' . $endpoint, [
            'headers' => $this->authHeaders,
        ])->toArray();
    }

    private function importGuidelines() {
        $response = $this->getRequestToApi('guidelines?order[authorisationDate]=desc');

        foreach($response['hydra:member'] as $index => $hydraGuideline) {
            $guideline = new Guideline();
            $guideline->setTitle($hydraGuideline['title'])
                ->setExternalId($hydraGuideline['@id']);

            $this->entityManager->persist($guideline);
            $this->entityManager->flush();

            if ($index == 24) {
                break;
            }
        }
    }


    private function importModules() {
        $response = $this->getRequestToApi('modules');

        foreach($response['hydra:member'] as $hydraModule) {
            $module = new Module();
            $module->setTitle($hydraModule['title'])
                ->setExternalId($hydraModule['@id']);

            $this->entityManager->persist($module);
            $this->entityManager->flush();
        }
    }


    private function importGuideNavigations()
    {
        $response = $this->getRequestToApi('guideline_navigations');

        foreach ($response['hydra:member'] as $hydraGuidelineNavigation) {
            $guideline = $this->doctrine->getRepository(Guideline::class)->findOneBy(['externalId' => $hydraGuidelineNavigation['guideline']]);
            $module = $this->doctrine->getRepository(Module::class)->findOneBy(['externalId' => $hydraGuidelineNavigation['module']]);

            if (!$guideline) {
                continue;
            }

            $guidelineNavigation = new GuidelineNavigation();
            $guidelineNavigation->setTitle($hydraGuidelineNavigation['title'])
                ->setExternalId($hydraGuidelineNavigation['@id'])
                ->setGuideline($guideline)
                ->setModule($module);

            $this->entityManager->persist($guidelineNavigation);
            $this->entityManager->flush();
        }
    }


    private function importModuleReferences() {
        $response = $this->getRequestToApi('module_references');

        foreach($response['hydra:member'] as $hydraModuleReference) {
            $module = $this->doctrine->getRepository(Module::class)->findOneBy(['externalId' => $hydraModuleReference['module']]);

            if (!$module) {
                continue;
            }

            $moduleReference = new ModuleReference();
            $moduleReference->setContent($hydraModuleReference['content'])
                ->setExternalId($hydraModuleReference['@id'])
                ->setModule($module);

            $this->entityManager->persist($moduleReference);
            $this->entityManager->flush();
        }
    }

    private function importModuleHyperlinks() {
        $response = $this->getRequestToApi('module_hyperlinks');

        foreach($response['hydra:member'] as $hydraModuleHyperlinks) {
            $module = $this->doctrine->getRepository(Module::class)->findOneBy(['externalId' => $hydraModuleHyperlinks['module']]);

            if (!$module) {
                continue;
            }

            $moduleHyperlink = new ModuleHyperlink();
            $moduleHyperlink->setTitle($hydraModuleHyperlinks['title'])
                ->setUrl($hydraModuleHyperlinks['url'])
                ->setExternalId($hydraModuleHyperlinks['@id'])
                ->setModule($module);

            $this->entityManager->persist($moduleHyperlink);
            $this->entityManager->flush();
        }
    }
}