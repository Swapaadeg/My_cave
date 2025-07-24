<?php

namespace App\Repository;

use App\Entity\Bouteilles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Bouteilles>
 */
class BouteillesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bouteilles::class);
    }

        public function getFilteredQueryBuilder(array $filters)
    {
        $qb = $this->createQueryBuilder('b');

        if (!empty($filters['nom'])) {
            $qb->andWhere('LOWER(b.nom) LIKE :nom')
            ->setParameter('nom', strtolower($filters['nom']) . '%');
        }

        if (!empty($filters['type'])) {
            $qb->andWhere('b.type IN (:types)')
            ->setParameter('types', $filters['type']);
        }

        if (!empty($filters['pays'])) {
            $qb->andWhere('LOWER(b.pays) LIKE :pays')
            ->setParameter('pays', strtolower($filters['pays']) . '%');
        }

        if (!empty($filters['region'])) {
            $qb->andWhere('LOWER(b.region) LIKE :region')
            ->setParameter('region', strtolower($filters['region']) . '%');
        }

        if (!empty($filters['cepage'])) {
            $qb->andWhere('LOWER(b.cepage) LIKE :cepage')
            ->setParameter('cepage', strtolower($filters['cepage']) . '%');
        }

        if (!empty($filters['millesime'])) {
            $qb->andWhere('b.millesime = :millesime')
            ->setParameter('millesime', $filters['millesime']);
        }

        return $qb;
    }

}
