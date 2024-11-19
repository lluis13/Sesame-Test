<?php

declare(strict_types=1);

namespace App\Application\CommandHandler\User;

use App\Application\Command\User\DeleteUserCommand;
use App\Domain\Model\Service\EventPublisher;
use App\Domain\Model\User\UserRepositoryInterface;
use App\Infrastructure\Bus\CommandHandlerInterface;
use Ramsey\Uuid\Uuid;

/**
 * @author Lluís Puig Ferrer <lluis_96_13@hotmail.com>
 */
final readonly class DeleteUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private EventPublisher          $eventPublisher,
    ) {
    }

    public function __invoke(DeleteUserCommand $command): void
    {
        $user = $this->userRepository->findByIdOrFail(Uuid::fromString($command->uuid));

        $user->delete();

        $this->userRepository->save($user);

        $this->eventPublisher->publish($user->getDomainEvents());
    }
}
