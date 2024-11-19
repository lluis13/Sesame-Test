<?php

namespace App\Infrastructure\Doctrine\Repository\User;

use App\Domain\Model\User\UserViewRepositoryInterface;
use Doctrine\DBAL\Connection;
use Ramsey\Uuid\Uuid;

/**
 * @author Lluís Puig Ferrer <lluis_96_13@hotmail.com>
 */
class MysqlUserViewRepository implements UserViewRepositoryInterface
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getUserDataById(Uuid $userId): ?array
    {
        $sql = <<<SQL
            SELECT
                BIN_TO_UUID(id) AS id,
                name,
                email,
                password,
                created_at,
                updated_at,
                deleted_at
            FROM user
            WHERE id = UUID_TO_BIN(:user_id);
        SQL;

        return $this->connection->executeQuery(
            $sql,
            [
                'user_id' => $userId->toString(),
            ],
        )->fetchAssociative() ?: null;
    }
}
