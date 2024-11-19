<?php

declare(strict_types=1);

namespace App\Application\QueryHandler\User;

use App\Application\Query\User\GetUserDataByIdQuery;
use App\Domain\Model\User\UserViewRepositoryInterface;
use App\Infrastructure\Bus\QueryHandlerInterface;
use Ramsey\Uuid\Uuid;

/**
 * @author Lluís Puig Ferrer <lluis_96_13@hotmail.com>
 */
final readonly class GetUserByIdQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private UserViewRepositoryInterface $userViewRepository,
    ) {}

    public function __invoke(GetUserDataByIdQuery $query): ?array
    {
        return $this->userViewRepository->getUserDataById(Uuid::fromString($query->uuid));
    }
}
