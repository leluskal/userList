<?php

namespace App\Service;

use App\Entity\User;

class UserRepository extends AbstractRepository
{
    protected function getEntityClassName(): string
    {
        return User::class;
    }

    /**
     * @return User[]
     */
    public function findAll(): array
    {
        return $this->getEntityManager()->createQueryBuilder()
            ->select('e')
            ->from(User::class, 'e')
            ->getQuery()
            ->getResult();
    }
}