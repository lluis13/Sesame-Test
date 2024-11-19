<?php

declare(strict_types=1);

namespace App\Application\CommandHandler\WorkEntry;

use App\Application\Command\WorkEntry\CreateWorkEntryCommand;
use App\Domain\Model\Service\EventPublisher;
use App\Domain\Model\WorkEntry\WorkEntry;
use App\Domain\Model\WorkEntry\WorkEntryRepositoryInterface;
use App\Domain\Model\User\UserRepositoryInterface;
use App\Infrastructure\Bus\CommandHandlerInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * @author Lluís Puig Ferrer <lluis_96_13@hotmail.com>
 */
final readonly class CreateWorkEntryCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private EventPublisher $eventPublisher
    ) {}

    public function __invoke(CreateWorkEntryCommand $command): UuidInterface
    {
        $user = $this->userRepository->findByIdOrFail(Uuid::fromString($command->userUuid));

        $workEntryUuid = Uuid::uuid1();
        $user->createWorkEntry(new WorkEntry($workEntryUuid, $user));

        $this->userRepository->save($user);

        $this->eventPublisher->publish($user->getDomainEvents());

        return $workEntryUuid;
    }
}
