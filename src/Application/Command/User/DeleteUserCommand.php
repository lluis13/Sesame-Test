<?php

namespace App\Application\Command\User;

/**
 * @author Lluís Puig Ferrer <lluis_96_13@hotmail.com>
 */
final readonly class DeleteUserCommand {
    public function __construct(
        public string $uuid,
    ) {}
}
