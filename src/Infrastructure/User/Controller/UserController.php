<?php

namespace App\Infrastructure\User\Controller;

use App\Application\Command\User\CreateUserCommand;
use App\Application\Command\User\DeleteUserCommand;
use App\Application\Command\User\UpdateUserCommand;
use App\Application\Query\User\GetUserDataByIdQuery;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * @author Lluís Puig Ferrer <lluis_96_13@hotmail.com>
 */
class UserController {
    use HandleTrait;

    public function createUser(MessageBusInterface $commandBus, Request $request): JsonResponse
    {
        $this->messageBus = $commandBus;

        $data = json_decode($request->getContent(), true);

        /** @var Uuid $uuid */
        $uuid = $this->handle(new CreateUserCommand(
            $data['name'],
            $data['email'],
            password_hash($data['password'], PASSWORD_DEFAULT)
        ));


        return new JsonResponse("User created with id: $uuid", 200);
    }

    public function updateUser(string $uuid, Request $request, MessageBusInterface $commandBus): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $commandBus->dispatch(new UpdateUserCommand(
            $uuid,
            $data['name'],
            $data['email'],
            password_hash($data['password'], PASSWORD_DEFAULT)
        ));

        return new JsonResponse('User updated successfully', 200);
    }

    public function deleteUser(string $uuid, MessageBusInterface $commandBus): JsonResponse
    {
        $commandBus->dispatch(new DeleteUserCommand(
            $uuid,
        ));

        return new JsonResponse('User deleted successfully', 200);
    }

    public function getUser(string $uuid, MessageBusInterface $queryBus): JsonResponse
    {
        $this->messageBus = $queryBus;

        $userData = $this->handle(new GetUserDataByIdQuery($uuid));

        return new JsonResponse($userData);
    }
}
