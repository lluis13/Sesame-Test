<?php

namespace App\Infrastructure\Utilities\FieldTypes;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Platforms\MySQLPlatform;
use Doctrine\DBAL\Types\Type;
use Ramsey\Uuid\Uuid;

/**
 * @author Lluís Puig Ferrer <lluis_96_13@hotmail.com>
 */
class UuidBinary extends Type
{
    public const NAME = 'uuid_binary';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        if ($platform instanceof MySQLPlatform) {
            return 'BINARY(16)';
        }

        return $platform->getBinaryTypeDeclarationSQL($fieldDeclaration);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): mixed {
        if ($value === null) {
            return null;
        }

        return Uuid::fromBytes($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed {
        if ($value === null) {
            return null;
        }

        return Uuid::fromString($value)->getBytes();
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
