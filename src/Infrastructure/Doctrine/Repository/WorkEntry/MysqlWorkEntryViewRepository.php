<?php

namespace App\Infrastructure\Doctrine\Repository\WorkEntry;

use App\Domain\Model\WorkEntry\WorkEntryViewRepositoryInterface;
use Doctrine\DBAL\Connection;
use Symfony\Component\Uid\Uuid;

/**
 * @author Lluís Puig Ferrer <lluis_96_13@hotmail.com>
 */
class MysqlWorkEntryViewRepository implements WorkEntryViewRepositoryInterface
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getWorkEntryDataByWorkEntryId(Uuid $workEntryId): ?array
    {
        $sql = <<<SQL
            SELECT
                BIN_TO_UUID(id) AS work_entry_id,
                start_date,
                end_date,
                created_at,
                updated_at,
                deleted_at,
                BIN_TO_UUID(user_id) AS user_id
            FROM work_entry
            WHERE id = UUID_TO_BIN(:workentry_id);
        SQL;

        return $this->connection->executeQuery(
            $sql,
            [
                'workentry_id' => $workEntryId->toString(),
            ],
        )->fetchAssociative() ?: null;
    }

    public function getAllWorkEntriesByUserId(Uuid $userId): ?array {
        $sql = <<<SQL
            SELECT
                BIN_TO_UUID(id) AS work_entry_id,
                start_date,
                end_date,
                created_at,
                updated_at,
                deleted_at,
                BIN_TO_UUID(user_id) AS user_id
            FROM work_entry
            WHERE user_id = UUID_TO_BIN(:user_id)
            ORDER BY created_at ASC
        SQL;

        return $this->connection->executeQuery(
            $sql,
            [
                'user_id' => $userId->toString(),
            ],
        )->fetchAllAssociative() ?: null;
    }
}
