<?php

declare(strict_types=1);

namespace App\Domain\Model\WorkEntry;
use App\Domain\Model\User\User;
use Ramsey\Uuid\Uuid;

/**
 * @author Lluís Puig Ferrer <lluis_96_13@hotmail.com>
 */
interface WorkEntryRepositoryInterface
{
    public function findByIdOrFail(Uuid $workEntry): WorkEntry;

    public function save(WorkEntry $workEntry): void;
}
