<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class DeployCommand extends Command
{
    protected static $defaultName = 'deploy';

    protected function configure()
    {
        $this
            ->setDescription('Lance les commandes de déploiement de projet')
            ->addOption('fixtures', null, InputOption::VALUE_NONE, 'Charge les fixtures (attention les données seront supprimées !)')
            ->addOption('serve', null, InputOption::VALUE_NONE, 'Lance le serveur après l\'exécution des scripts')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $io->success('Installation de dépendances Composer et Yarn...');
        exec('yarn install --quiet');
        exec('composer install --quiet');
        $output->writeln('Dépendances installées.');

        $io->success('Migrations Doctrine éventuelles...');
        exec('php bin/console migrate --quiet');
        $output->writeln('Migrations effectuées.');

        $io->success('Génération des assets avec Encore...');
        exec('yarn encore dev -quiet');
        $output->writeln('Assets chargés.');


        if ($input->getOption('fixtures')) {
            $io->success('Chargement des fixtures...');
            exec ('php bin/console doctrine:fixtures:load');
        }

        $io->success('Terminé !');

        if ($input->getOption('serve')) {

            $io->success('Lancement du serveur...');

            exec('php bin/console server:run');
        }

    }
}
