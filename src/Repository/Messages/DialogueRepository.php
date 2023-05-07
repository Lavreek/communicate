<?php

namespace App\Repository\Messages;

use App\Entity\Messages\Dialogue;
use App\Entity\Messages\Letter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Dialogue>
 *
 * @method Dialogue|null find($id, $lockMode = null, $lockVersion = null)
 * @method Dialogue|null findOneBy(array $criteria, array $orderBy = null)
 * @method Dialogue[]    findAll()
 * @method Dialogue[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DialogueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Dialogue::class);
    }

    public function save(Dialogue $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Dialogue $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Dialogue[] Returns an array of Letter objects
     */
    public function findMessages($user_id, $vis_id): array
    {
        return $this->createQueryBuilder('d')
            ->andWhere("d.from_u_id = $user_id AND d.to_u_id = $vis_id")
            ->orWhere("d.from_u_id = $vis_id AND d.to_u_id = $user_id")
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(100)
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @return Dialogue[] Returns an array of Letter objects
     */
    public function findDialogs($user_id): array
    {
        return $this->createQueryBuilder('d')
            ->distinct()
            ->select('d.from_u_id, d.to_u_id')
            ->where("d.from_u_id = :uid OR d.to_u_id = :uid")
            ->setParameter('uid', $user_id)
            ->orderBy('d.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

//    /**
//     * @return Dialogue[] Returns an array of Dialogue objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Dialogue
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
