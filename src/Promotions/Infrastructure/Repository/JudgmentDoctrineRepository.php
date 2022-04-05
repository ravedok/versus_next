<?php

namespace VS\Next\Promotions\Infrastructure\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use VS\Next\Promotions\Domain\Judgment\Judgment;
use VS\Next\Promotions\Domain\Judgment\JudgmentRepository;

/**
 * @extends  ServiceEntityRepository<Judgment>
 */
class JudgmentDoctrineRepository extends ServiceEntityRepository implements JudgmentRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Judgment::class);
    }

    public function findActives(): array
    {
        $qb = $this->createQueryBuilder('j');
        $expr = $qb->expr();

        return $qb
            ->addSelect('p')
            ->join('j.promotion', 'p')
            ->where($expr->eq('p.active', true))
            ->andWhere(
                $expr->orX(
                    $expr->isNull('p.duration.startAt'),
                    $expr->lte('p.duration.startAt', ':now')
                )
            )
            ->andWhere(
                $expr->orX(
                    $expr->isNull('p.duration.endAt'),
                    $expr->gte('p.duration.endAt', ':now')
                )
            )
            ->setParameter('now', new \DateTime())
            ->getQuery()
            ->getResult();
    }
}
