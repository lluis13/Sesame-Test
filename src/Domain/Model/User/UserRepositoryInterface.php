<?php

declare(strict_types=1);

namespace App\Domain\Model\User;

use Ramsey\Uuid\Uuid;

/**
 * @author Lluís Puig Ferrer <lluis_96_13@hotmail.com>
 */
interface UserRepositoryInterface
{
    public function findByIdOrFail(Uuid $userId): User;

    public function save(User $user): void;
}
