<?php

namespace App\Repository;

use App\Entity\Rating;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;









class RatingRespository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rating::class);
    }


public function selectbyevent($str)
{
    return $this->getEntityManager()
        ->createQuery(
            'SELECT e FROM APP\Entity\Equipement e
            JOIN e.Ratings p 
            WHERE p.user = :str'
        )
        ->setParameter('str', $str)
        ->getResult();
}
public function selectByUser($iduser)
{
    return $this->createQueryBuilder('r')
        ->where('r.iduser = :iduser')
        ->setParameter('iduser', $iduser)
        ->getQuery()
        ->getResult();
}
 

}