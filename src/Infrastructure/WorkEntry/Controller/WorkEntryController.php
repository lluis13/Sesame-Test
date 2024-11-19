<?php

namespace App\Infrastructure\WorkEntry\Controller;

use App\Application\Command\WorkEntry\CreateWorkEntryCommand;
use App\Application\Command\WorkEntry\DeleteWorkEntryCommand;
use App\Application\Command\WorkEntry\EndWorkEntryCommand;
use App\Application\Command\WorkEntry\StartWorkEntryCommand;
use App\Application\Command\WorkEntry\UpdateWorkEntryCommand;
use App\Application\Query\WorkEntry\GetAllWorkEntriesByUserIdQuery;
use App\Application\Query\WorkEntry\GetWorkEntryByWorkEntryIdQuery;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * @author Lluís Puig Ferrer <lluis_96_13@hotmail.com>
 */
class WorkEntryController extends AbstractController {
    use HandleTrait;

    public function createWorkEntry(MessageBusInterface $commandBus, Request $request): JsonResponse
    {
        $this->messageBus = $commandBus;

        $data = json_decode($request->getContent(), true);

        /** @var Uuid $uuid */
        $uuid = $this->handle(new CreateWorkEntryCommand(
            $data['user_id'],
        ));

        return new JsonResponse("Work entry created with id: $uuid", 200);
    }

    public function updateWorkEntry(
        string $workEntryUuid,
        string $userUuid,
        Request $request,
        MessageBusInterface $commandBus
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        $commandBus->dispatch(new UpdateWorkEntryCommand(
            $workEntryUuid,
            $userUuid,
            new \DateTimeImmutable($data['start_date']),
            new \DateTimeImmutable($data['end_date'])
        ));

        return new JsonResponse('Work entry updated successfully', 200);
    }

    public function deleteWorkEntry(
        string $workEntryUuid,
        string $userUuid,
        MessageBusInterface $commandBus
    ): JsonResponse {
        $commandBus->dispatch(new DeleteWorkEntryCommand($workEntryUuid, $userUuid));

        return new JsonResponse('Work entry deleted successfully', 200);
    }

    public function getWorkEntry(
        string $workEntryUuid,
        string $userUuid,
        MessageBusInterface $queryBus
    ): JsonResponse {
        $this->messageBus = $queryBus;

        $workEntryData = $this->handle(new GetWorkEntryByWorkEntryIdQuery($workEntryUuid, $userUuid));

        return new JsonResponse($workEntryData);
    }


    public function startWorkEntry(MessageBusInterface $commandBus): JsonResponse
    {
        $this->messageBus = $commandBus;

        $uuid = $this->handle(new StartWorkEntryCommand(
            $this->getUser()?->id()->toString(),
        ));

        return new JsonResponse("Work entry started successfully $uuid", 200);
    }


    public function endWorkEntry(
        string $workEntryUuid,
        MessageBusInterface $commandBus
    ): JsonResponse
    {
        $commandBus->dispatch(new EndWorkEntryCommand(
            $workEntryUuid,
            $this->getUser()?->id()->toString(),
        ));
        return new JsonResponse('Work entry end successfully', 200);
    }


    public function getWorkEntries(MessageBusInterface $queryBus): JsonResponse
    {
        $this->messageBus = $queryBus;

        $allUserWorkEntries = $this->handle(new GetAllWorkEntriesByUserIdQuery(
            $this->getUser()?->id()->toString(),
        ));
        return new JsonResponse($allUserWorkEntries, 200);
    }
}
