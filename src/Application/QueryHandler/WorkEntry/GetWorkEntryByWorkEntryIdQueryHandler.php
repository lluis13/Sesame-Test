<?php

declare(strict_types=1);

namespace App\Application\QueryHandler\WorkEntry;

use App\Application\Query\WorkEntry\GetWorkEntryByWorkEntryIdQuery;
use App\Domain\Model\WorkEntry\WorkEntryViewRepositoryInterface;
use App\Infrastructure\Bus\QueryHandlerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Uid\Uuid;

/**
 * @author Lluís Puig Ferrer <lluis_96_13@hotmail.com>
 */
final readonly class GetWorkEntryByWorkEntryIdQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private WorkEntryViewRepositoryInterface $workEntryViewRepository
    ) {}

    public function __invoke(GetWorkEntryByWorkEntryIdQuery $query): ?array
    {
        return $this->workEntryViewRepository->getWorkEntryDataByWorkEntryId(Uuid::fromString($query->workEntryUuid));
    }
}
