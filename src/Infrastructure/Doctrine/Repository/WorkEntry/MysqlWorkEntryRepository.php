<?php

namespace App\Infrastructure\Doctrine\Repository\WorkEntry;

use App\Application\Exception\WorkEntry\WorkEntryNotFoundException;
use App\Domain\Model\WorkEntry\WorkEntry;
use App\Domain\Model\WorkEntry\WorkEntryRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\Uuid;

/**
 * @author Lluís Puig Ferrer <lluis_96_13@hotmail.com>
 */
class MysqlWorkEntryRepository extends ServiceEntityRepository implements WorkEntryRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WorkEntry::class);
    }

    /**
     * @inheritDoc
     */
    public function findByIdOrFail(Uuid $workEntry): WorkEntry
    {
        $user = $this->find($workEntry);

        if ($user === null) {
            throw WorkEntryNotFoundException::becauseDoesNotExists($workEntry);
        }

        return $user;
    }

    /**
     * @inheritDoc
     */
    public function save(WorkEntry $workEntry): void
    {
        $this->getEntityManager()->persist($workEntry);
        $this->getEntityManager()->flush();
    }
}
