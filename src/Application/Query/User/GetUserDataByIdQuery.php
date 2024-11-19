<?php

namespace App\Application\Query\User;

/**
 * @author Lluís Puig Ferrer <lluis_96_13@hotmail.com>
 */
final readonly class GetUserDataByIdQuery
{
    public function __construct(
        public string $uuid
    ) {}
}
