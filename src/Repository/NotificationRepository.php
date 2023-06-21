<?php

namespace PaulLab\NotificationBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use PaulLab\NotificationBundle\Entity\Notification;
use DateTimeInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use PaulLab\NotificationBundle\ValueObject\NotificationLevel;

/**
 * @extends ServiceEntityRepository<Notification>
 *
 * @method Notification|null find($id, $lockMode = null, $lockVersion = null)
 * @method Notification|null findOneBy(array $criteria, array $orderBy = null)
 * @method Notification[]    findAll()
 * @method Notification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotificationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Notification::class);
    }

    /**
     * @param Notification $notification
     */
    public function save(Notification $notification): void
    {
        $this->getEntityManager()->persist($notification);
        $this->getEntityManager()->flush();
    }

    /**
     * @return int
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function countUnread(): int
    {
        return $this->createQueryBuilder('n')
            ->select('COUNT(n.id)')
            ->andWhere('n.read_at IS NULL')
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @param DateTimeInterface $dateTime
     * @param NotificationLevel|null $level
     * @return int
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function deleteOlderThan(DateTimeInterface $dateTime, ?NotificationLevel $level): int
    {
        $queryBuilder = $this->createQueryBuilder('n')
            ->where('n.send_at < :date')
            ->setParameter('date', $dateTime);

        if (null !== $level) {
            $queryBuilder->andWhere('n.level = :level')
                ->setParameter('level', $level);
        }

        $countQuery = clone($queryBuilder);
        $count = $countQuery->select('COUNT(n.id)')
            ->getQuery()
            ->getSingleScalarResult();

        $queryBuilder->delete()
            ->getQuery()
            ->execute();

        return $count;
    }
}
