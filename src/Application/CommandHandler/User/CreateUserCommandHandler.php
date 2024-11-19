<?php

declare(strict_types=1);

namespace App\Application\CommandHandler\User;

use App\Application\Command\User\CreateUserCommand;
use App\Domain\Model\Service\EventPublisher;
use App\Domain\Model\User\Email;
use App\Domain\Model\User\Name;
use App\Domain\Model\User\Password;
use App\Domain\Model\User\User;
use App\Domain\Model\User\UserRepositoryInterface;
use App\Infrastructure\Bus\CommandHandlerInterface;
use Ramsey\Uuid\Uuid;

/**
 * @author Lluís Puig Ferrer <lluis_96_13@hotmail.com>
 */
final readonly class CreateUserCommandHandler implements CommandHandlerInterface {
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private EventPublisher          $eventPublisher,
    ) {
    }

    public function __invoke(CreateUserCommand $command): Uuid {
        $user = new User(
            new Name($command->name),
            new Email($command->email),
            new Password($command->password),
        );

        $this->userRepository->save($user);

        $this->eventPublisher->publish($user->getDomainEvents());

        return $user->id();
    }
}
