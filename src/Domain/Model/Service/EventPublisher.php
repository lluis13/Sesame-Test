<?php

namespace App\Domain\Model\Service;

use App\Application\EventInterface;
use App\Domain\Model\Event\Event;
use App\Domain\Model\Event\EventRepositoryInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class EventPublisher
{
    public function __construct(
        private EventRepositoryInterface $eventRepository,
        private MessageBusInterface $eventBus,
    ) {
    }

    public function publish(array $events): void
    {
        /** @var EventInterface $event */
        foreach ($events as $event) {
            $this->eventBus->dispatch($event);

            $event = new Event(
                $event->getType(),
                $event->occurredAt(),
                $event->getPayload(),
            );

            $this->eventRepository->save($event);
        }
    }
}
