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
        $qb = $this->createQueryBuilder('b')
            ->leftJoin('b.type', 't', 'LEFT') // Jointure LEFT sans condition supplémentaire
            ->leftJoin('b.pays', 'p', 'LEFT')
            ->leftJoin('b.region', 'r', 'LEFT')
            ->leftJoin('b.cepage', 'c', 'LEFT')
            ->addSelect('t', 'p', 'r', 'c');

        if (!empty($filters['nom'])) {
            $qb->andWhere('LOWER(b.nom) LIKE :nom')
            ->setParameter('nom', '%' . strtolower($filters['nom']) . '%');
        }

        if (isset($filters['type']) && !empty($filters['type']) && count($filters['type']) > 0) {
            $typeIds = $filters['type'] instanceof \Doctrine\Common\Collections\ArrayCollection
                ? $filters['type']->map(function ($type) { return $type->getId(); })->toArray()
                : (is_array($filters['type']) ? array_map(function ($type) { return $type->getId(); }, $filters['type']) : [$filters['type']->getId()]);
            $qb->andWhere('t.id IN (:types)')
            ->setParameter('types', $typeIds);
        }

        if (!empty($filters['pays'])) {
            $paysId = $filters['pays'] instanceof \App\Entity\Pays ? $filters['pays']->getId() : $filters['pays'];
            $qb->andWhere('p.id = :pays')
            ->setParameter('pays', $paysId);
            \dump('Pays ID:', $paysId);
        }

        if (!empty($filters['region'])) {
            $regionId = $filters['region'] instanceof \App\Entity\Region ? $filters['region']->getId() : $filters['region'];
            $qb->andWhere('r.id = :region')
            ->setParameter('region', $regionId);
            \dump('Region ID:', $regionId);

            if (!empty($filters['pays'])) {
                $paysId = $filters['pays'] instanceof \App\Entity\Pays ? $filters['pays']->getId() : $filters['pays'];
                $qb->andWhere('r.pays = :pays')
                ->setParameter('pays', $paysId);
            }
        }

        if (!empty($filters['cepage'])) {
            $cepageId = $filters['cepage'] instanceof \App\Entity\Cepage ? $filters['cepage']->getId() : $filters['cepage'];
            $qb->andWhere('c.id = :cepage')
            ->setParameter('cepage', $cepageId);
            \dump('Cepage ID:', $cepageId);
        }

        if (!empty($filters['millesime'])) {
            $qb->andWhere('b.millesime = :millesime')
            ->setParameter('millesime', $filters['millesime']);
        }

        $query = $qb->getQuery();
        $sql = $query->getSQL();
        $params = $query->getParameters()->toArray();
        \dump('SQL Query:', $sql, $params);

        return $qb;
    }
}