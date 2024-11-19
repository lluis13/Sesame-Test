<?php

namespace App\Infrastructure\Doctrine\Repository\Event;

use App\Application\Exception\WorkEntry\WorkEntryNotFoundException;
use App\Domain\Model\Event\Event;
use App\Domain\Model\Event\EventRepositoryInterface;
use App\Domain\Model\WorkEntry\WorkEntry;
use App\Domain\Model\WorkEntry\WorkEntryRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\Uuid;

/**
 * @author Lluís Puig Ferrer <lluis_96_13@hotmail.com>
 */
class MysqlEventRepository extends ServiceEntityRepository implements EventRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function save(Event $event): void
    {
        $this->getEntityManager()->persist($event);
        $this->getEntityManager()->flush();
    }
}
