<?php

declare(strict_types=1);

namespace Doctrine\ORM\Query;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Types\Type;

/**
 * Provides an enclosed support for parameter inferring.
 */
class ParameterTypeInferer
{
    /**
     * Infers type of a given value, returning a compatible constant:
     * - Type (\Doctrine\DBAL\Types\Type::*)
     * - Connection (\Doctrine\DBAL\Connection::PARAM_*)
     *
     * @param mixed $value Parameter value.
     *
     * @return mixed Parameter type constant.
     */
    public static function inferType($value)
    {
        if (is_int($value)) {
            return Type::INTEGER;
        }

        if (is_bool($value)) {
            return Type::BOOLEAN;
        }

        if ($value instanceof \DateTimeInterface) {
            return Type::DATETIME;
        }

        if ($value instanceof \DateInterval) {
            return Type::DATEINTERVAL;
        }

        if (is_array($value)) {
            return is_int(current($value))
                ? Connection::PARAM_INT_ARRAY
                : Connection::PARAM_STR_ARRAY;
        }

        return \PDO::PARAM_STR;
    }
}
