<?php

namespace App\Service;

use App\Entity\LoginAttempt;
use App\Entity\User;

class LoginAttemptRepository extends AbstractRepository
{
    protected function getEntityClassName(): string
    {
        return LoginAttempt::class;
    }

    /**
     * @param User[] $users
     * @return array|int
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function countLoginAttemptsByUsers(array $users): array
    {
        $userIds = [];
        foreach ($users as $user) {
            $userIds[] = $user->getId();
        }

        $resultArray = $this->getEntityManager()->createQueryBuilder()
            ->select('u.id, COUNT(la.id) as attempts_count')
            ->from(LoginAttempt::class, 'la')
            ->leftJoin('la.user', 'u')
            ->where('la.user IN (:userIds)')
            ->setParameter('userIds', $userIds)
            ->groupBy('u.id')
            ->getQuery()
            ->getResult();

        $returnArray = [];

        foreach ($resultArray as $result) {
            $returnArray[$result['id']] = $result['attempts_count'];
        }

        return $returnArray;
    }
}