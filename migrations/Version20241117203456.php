<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241118123456 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $sql = <<<SQL
            CREATE TABLE user (
                id BINARY(16) PRIMARY KEY NOT NULL,
                name VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                created_at DATETIME NOT NULL,
                updated_at DATETIME NOT NULL,
                deleted_at DATETIME NULL
            );

            CREATE TABLE work_entry (
                id BINARY(16) PRIMARY KEY NOT NULL,
                user_id BINARY(16) NOT NULL,
                start_date DATETIME NOT NULL,
                end_date DATETIME NULL,
                created_at DATETIME NOT NULL,
                updated_at DATETIME NOT NULL,
                deleted_at DATETIME NULL,
                FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE
            );

            CREATE INDEX work_entry_user_id_index ON work_entry(user_id);

            CREATE UNIQUE INDEX user_email_unique ON user(email);

            CREATE TABLE event_history (
                id BINARY(16) PRIMARY KEY NOT NULL,
                type VARCHAR(255) NOT NULL,
                payload JSON NULL,
                occurred_at DATETIME NOT NULL
            );
        SQL;

        $this->addSql($sql);
    }

    public function down(Schema $schema): void
    {
        $sql = <<<SQL
            DROP TABLE IF EXISTS work_entry;
            DROP TABLE IF EXISTS user;
        SQL;

        $this->addSql($sql);
    }
}
