<?php

declare(strict_types=1);

namespace App\Application\CommandHandler\WorkEntry;

use App\Application\Command\WorkEntry\EndWorkEntryCommand;
use App\Domain\Model\Service\EventPublisher;
use App\Domain\Model\User\UserRepositoryInterface;
use App\Domain\Model\WorkEntry\WorkEntryRepositoryInterface;
use App\Infrastructure\Bus\CommandHandlerInterface;
use Ramsey\Uuid\Uuid;

/**
 * @author Lluís Puig Ferrer <lluis_96_13@hotmail.com>
 */
final readonly class EndWorkEntryCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private WorkEntryRepositoryInterface $workEntryRepository,
        private EventPublisher $eventPublisher,
        private UserRepositoryInterface $userRepository,
    ) {}

    public function __invoke(EndWorkEntryCommand $command): void
    {
        $user = $this->userRepository->findByIdOrFail(Uuid::fromString($command->userUuid));
        $workEntry = $this->workEntryRepository->findByIdOrFail(Uuid::fromString($command->workEntryUuid));

        $user->endWorkEntry($workEntry);

        $this->userRepository->save($user);

        $this->eventPublisher->publish($user->getDomainEvents());
    }
}
