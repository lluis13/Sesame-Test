<?php

declare(strict_types=1);

namespace App\Application\CommandHandler\User;

use App\Application\Command\User\UpdateUserCommand;
use App\Domain\Model\Service\EventPublisher;
use App\Domain\Model\User\Email;
use App\Domain\Model\User\Name;
use App\Domain\Model\User\Password;
use App\Domain\Model\User\UserRepositoryInterface;
use App\Infrastructure\Bus\CommandHandlerInterface;
use Ramsey\Uuid\Uuid;

/**
 * @author Lluís Puig Ferrer <lluis_96_13@hotmail.com>
 */
final readonly class UpdateUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private EventPublisher          $eventPublisher,
    ) {
    }

    public function __invoke(UpdateUserCommand $command): void
    {
        $user = $this->userRepository->findByIdOrFail(Uuid::fromString($command->uuid));

        $user->update(
            new Name($command->name),
            new Email($command->email),
            new Password($command->password),
        );

        $this->userRepository->save($user);

        $this->eventPublisher->publish($user->getDomainEvents());
    }
}
