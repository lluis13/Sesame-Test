<?php

declare(strict_types=1);

namespace App\Application\CommandHandler\WorkEntry;

use App\Application\Command\WorkEntry\UpdateWorkEntryCommand;
use App\Domain\Model\Service\EventPublisher;
use App\Domain\Model\User\UserRepositoryInterface;
use App\Domain\Model\WorkEntry\WorkEntryRepositoryInterface;
use App\Domain\Model\WorkEntry\WorkEntryTime;
use App\Infrastructure\Bus\CommandHandlerInterface;
use Ramsey\Uuid\Uuid;

/**
 * @author Lluís Puig Ferrer <lluis_96_13@hotmail.com>
 */
final readonly class UpdateWorkEntryCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private WorkEntryRepositoryInterface $workEntryRepository,
        private UserRepositoryInterface $userRepository,
        private EventPublisher $eventPublisher

    ) {}

    public function __invoke(UpdateWorkEntryCommand $command): void
    {
        $user = $this->userRepository->findByIdOrFail(Uuid::fromString($command->userUuid));
        $workEntry = $this->workEntryRepository->findByIdOrFail(Uuid::fromString($command->workEntryUuid));

        $user->updateWorkEntry($workEntry, new WorkEntryTime($command->startDate, $command->endDate));

        $this->userRepository->save($user);

        $this->eventPublisher->publish($user->getDomainEvents());

    }
}
