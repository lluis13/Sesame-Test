<?php

declare(strict_types=1);

namespace App\Domain\Model\User;

use Ramsey\Uuid\Uuid;

/**
 * @author Lluís Puig Ferrer <lluis_96_13@hotmail.com>
 */
interface UserViewRepositoryInterface
{
    public function getUserDataById(Uuid $userId): ?array;
}
