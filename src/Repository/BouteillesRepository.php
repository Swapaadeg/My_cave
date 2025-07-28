<?php

namespace App\Repository;

use App\Entity\Bouteilles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @extends ServiceEntityRepository<Bouteilles>
 */
class BouteillesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bouteilles::class);
    }

    public function getFilteredQueryBuilder(array $filters): QueryBuilder
    {
        $qb = $this->createQueryBuilder('b');

        // Jointure uniquement si affichage ou filtre
        $qb->leftJoin('b.type', 't')->addSelect('t');
        $qb->leftJoin('b.cepage', 'c')->addSelect('c');
        $qb->leftJoin('b.region', 'r')->addSelect('r');

        // Filtrage
        if (!empty($filters['region'])) {
            $regionId = is_object($filters['region']) ? $filters['region']->getId() : (int) $filters['region'];
            $qb->andWhere('r.id = :region')->setParameter('region', $regionId);
        }

        if (!empty($filters['nom'])) {
            $qb->andWhere('LOWER(b.nom) LIKE :nom')
                ->setParameter('nom', '%' . strtolower($filters['nom']) . '%');
        }

        if (!empty($filters['type'])) {
            $types = $filters['type'] instanceof \Doctrine\Common\Collections\Collection
                ? $filters['type']->toArray()
                : (array) $filters['type'];
            $typeIds = array_map(fn($t) => is_object($t) ? $t->getId() : (int) $t, $types);
            if (!empty($typeIds)) {
                $qb->andWhere('t.id IN (:types)')
                   ->setParameter('types', $typeIds);
            }
        }

        if (!empty($filters['pays'])) {
            $qb->leftJoin('b.pays', 'p')->addSelect('p');
            $paysId = is_object($filters['pays']) ? $filters['pays']->getId() : (int) $filters['pays'];
            $qb->andWhere('p.id = :pays')->setParameter('pays', $paysId);
        }

        if (!empty($filters['cepage'])) {
            $cepageId = is_object($filters['cepage']) ? $filters['cepage']->getId() : (int) $filters['cepage'];
            $qb->andWhere('c.id = :cepage')->setParameter('cepage', $cepageId);
        }

        if (!empty($filters['millesime'])) {
            $qb->andWhere('b.millesime = :millesime')
                ->setParameter('millesime', $filters['millesime']);
        }

        // Pas de dump ici pour la prod
        return $qb;
    }


}