<?php

namespace App\Infrastructure\Doctrine\Repository\Event;

use App\Domain\Model\Event\Event;
use App\Domain\Model\Event\EventRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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
