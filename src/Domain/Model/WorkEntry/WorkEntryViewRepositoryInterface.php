<?php

declare(strict_types=1);

namespace App\Domain\Model\WorkEntry;
use Symfony\Component\Uid\Uuid;

/**
 * @author Lluís Puig Ferrer <lluis_96_13@hotmail.com>
 */
interface WorkEntryViewRepositoryInterface
{
    public function getWorkEntryDataByWorkEntryId(Uuid $workEntryId): ?array;

    public function getAllWorkEntriesByUserId(Uuid $userId): ?array;
}
