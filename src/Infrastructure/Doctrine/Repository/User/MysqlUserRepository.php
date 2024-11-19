<?php

namespace App\Infrastructure\Doctrine\Repository\User;

use App\Application\Exception\User\UserNotFoundException;
use App\Domain\Model\User\User;
use App\Domain\Model\User\UserRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\Uuid;

/**
 * @author Lluís Puig Ferrer <lluis_96_13@hotmail.com>
 */
class MysqlUserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @inheritDoc
     */
    public function findByIdOrFail(Uuid $userId): User
    {
        $user = $this->find($userId);

        if ($user === null) {
            throw UserNotFoundException::becauseDoesNotExists($userId);
        }

        return $user;
    }

    /**
     * @inheritDoc
     */
    public function save(User $user): void
    {
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }
}
