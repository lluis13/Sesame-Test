<?php

namespace App\Application\Command\User;

/**
 * @author Lluís Puig Ferrer <lluis_96_13@hotmail.com>
 */
final readonly class UpdateUserCommand {
    public function __construct(
        public string $uuid,
        public string $name,
        public string $email,
        public string $password
    ) {}
}
