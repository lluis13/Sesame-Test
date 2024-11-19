<?php

declare(strict_types=1);

namespace App\Application\CommandHandler\WorkEntry;

use App\Application\Command\WorkEntry\DeleteWorkEntryCommand;
use App\Domain\Model\Service\EventPublisher;
use App\Domain\Model\User\UserRepositoryInterface;
use App\Domain\Model\WorkEntry\WorkEntryRepositoryInterface;
use App\Infrastructure\Bus\CommandHandlerInterface;
use Ramsey\Uuid\Uuid;

/**
 * @author Lluís Puig Ferrer <lluis_96_13@hotmail.com>
 */
final readonly class DeleteWorkEntryCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private WorkEntryRepositoryInterface $workEntryRepository,
        private UserRepositoryInterface $userRepository,
        private EventPublisher $eventPublisher
    ) {}

    public function __invoke(DeleteWorkEntryCommand $command): void
    {
        $user = $this->userRepository->findByIdOrFail(Uuid::fromString($command->userUuid));
        $workEntry = $this->workEntryRepository->findByIdOrFail(Uuid::fromString($command->workEntryUuid));

        $user->deleteWorkEntry($workEntry);

        $this->userRepository->save($user);

        $this->eventPublisher->publish($user->getDomainEvents());
    }
}
