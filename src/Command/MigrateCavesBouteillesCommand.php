<?php
// src/Command/MigrateCavesBouteillesCommand.php

namespace App\Command;

use App\Entity\Caves;
use App\Entity\CaveBouteille;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:migrate-caves-bouteilles',
    description: 'Migre les liaisons caves_bouteilles (ManyToMany) vers cave_bouteille (pivot avec quantité).',
)]
class MigrateCavesBouteillesCommand extends Command
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
        $this->em = $em;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $caves = $this->em->getRepository(Caves::class)->findAll();
        $count = 0;
        foreach ($caves as $cave) {
            foreach ($cave->getCavesBouteilles() as $bouteille) {
                $existing = $this->em->getRepository(CaveBouteille::class)->findOneBy([
                    'cave' => $cave,
                    'bouteille' => $bouteille
                ]);
                if (!$existing) {
                    $cb = new CaveBouteille();
                    $cb->setCave($cave);
                    $cb->setBouteille($bouteille);
                    $cb->setQuantite(1);
                    $this->em->persist($cb);
                    $count++;
                }
            }
        }
        $this->em->flush();
        $output->writeln("Migration terminée. $count liaisons migrées.");
        return Command::SUCCESS;
    }
}
